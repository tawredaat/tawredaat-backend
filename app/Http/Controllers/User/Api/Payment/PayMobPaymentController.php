<?php

namespace App\Http\Controllers\User\Api\Payment;

use App\Actions\Admin\Order\DecreaseShopProductQuantityAction;
use App\Actions\User\Cart\UpdateAddressWithDefaultAction;
use App\Actions\User\OnlineTransactionValu\StoreAction as OnlineTransactionValuStoreAction;
use App\Actions\User\OnlineTransaction\StoreAction;
use App\Actions\User\OnlineTransaction\UpdateOrderTransactionIdAction;
use App\Http\Controllers\User\Api\BaseResponse;
use App\Models\Cart;
use App\Models\CartItem;
use App\Repository\User\CheckoutRepo;
use App\Services\PaymentService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PayMobPaymentController extends BaseResponse
{
    protected $checkout_repo;
    protected $payment_service;

    public function __construct(PaymentService $payment_service, CheckoutRepo $checkout_repo)
    {
        $this->checkout_repo = $checkout_repo;
        $this->payment_service = $payment_service;
    }

    public function pay($cart_id,
        UpdateAddressWithDefaultAction $update_address_with_default_action) {
        try {
            // validate the cart
            $user_id = auth('api')->user()->id;

            $result = $this->checkout_repo->validateCart($user_id,
                $update_address_with_default_action);

            if ($result['success']) {
                $result = $this->payment_service->pay($cart_id);
                if ($result['status'] == 'success') {
                    return $this->response(200, $result['message'], 200, [], 0,
                        ['url' => $result['url']]);
                } else {
                    // repaying for the same cart
                    if ($result['error_code'] == Response::HTTP_UNPROCESSABLE_ENTITY
                        && str_contains($result['message'], 'duplicate')) {
                        $result = $this->newCartPaymentRetry($cart_id);

                        if ($result['status'] == 'success') {
                            return $this->response(200, $result['message'], 200, [], 0,
                                ['url' => $result['url']]);
                        }
                    }

                    $message = "";
                    if (isset($result['message'])) {
                        $message .= " ";
                        $message .= $result['message'];
                    }
                    return $this->response(500, __('validation.error') . $message, 500);
                }

            } elseif ($result['validator']) {
                return $this->response(101, "Validation Error", 200, $result['validator']);
            } elseif ($result['errors']) {
                return $this->response(500, $result['errors'], 500);
            } else {
                return $this->response(500, "Error", 500);
            }

        } catch (\Exception $e) {
            return $this->response(500, __('validation.error') . ' ' . $e->getMessage(), 500);
        }
    }

    // after paying this is the next step POST
    // just handling the paymob notification when it gets sent by paymob
    public function processedCallback(Request $request, StoreAction $store_action,
        OnlineTransactionValuStoreAction $valu_transaction_store_action,
        UpdateOrderTransactionIdAction $update_order_transaction_id_action,
        DecreaseShopProductQuantityAction $decrease_shop_product_quantity_action) {
        try {
            // Storage::put('post request.json', $request->getContent());
            $decoded_json = json_decode($request->getContent(), true);

            // hmac calculation to insure the paymob is the sender of the request
            try {
                $calculated_hashed_string = $this->calculateHashedStringPost($decoded_json);
                if ($calculated_hashed_string != $request->hmac) {
                    return 'invalid HMAC';
                }
            } catch (\Exception $e) {
                return 'error';
            }

            DB::beginTransaction();
            if ($decoded_json['obj']['success'] == true
                && $decoded_json['obj']['pending'] == false) {
                // checkout
                $cart_id = $decoded_json['obj']['order']['merchant_order_id'];
                $cart = Cart::findOrFail($cart_id);
                $user_id = $cart->user_id;
                $user = User::findOrFail($user_id);
                $result = $this->checkout_repo->checkout($user,
                    $decrease_shop_product_quantity_action);

                if ($result['success']) {
                    // from order get user id
                    $online_transaction = $store_action->execute($user_id, $decoded_json, 1);
                    // update latest order for the user with the transaction id
                    $order_id = $result['object']['order']['id'];
                    $updated = $update_order_transaction_id_action->execute($order_id, $decoded_json);

                    // saving valu info
                    if ($cart->payment_id == config('payment_paymob.valu.payment_id', 2)) {
                        $valu_transaction_store_action->execute($decoded_json,
                            $online_transaction->id);
                    }
                }
                DB::commit();
                return 'success';
            }
        } catch (\Exception $e) {
            DB::rollback();
            info('Exception in the processed callback, message' . $e->getMessage() . 'trace=' . $e->getTraceAsString());
            return 'error';
        }
    }

    private function calculateHashedStringPost($data)
    {
        $amount_cents = $data['obj']['amount_cents'];
        $created_at = $data['obj']['created_at'];
        $currency = $data['obj']['currency'];
        $error_occured = $data['obj']['error_occured'] ? 'true' : 'false';
        $has_parent_transaction = $data['obj']['has_parent_transaction'] ? 'true' : 'false';
        $id = $data['obj']['id'];
        $integration_id = $data['obj']['integration_id'];
        $is_3d_secure = $data['obj']['is_3d_secure'] ? 'true' : 'false';
        $is_auth = $data['obj']['is_auth'] ? 'true' : 'false';
        $is_capture = $data['obj']['is_capture'] ? 'true' : 'false';
        $is_refunded = $data['obj']['is_refunded'] ? 'true' : 'false';
        $is_standalone_payment = $data['obj']['is_standalone_payment'] ? 'true' : 'false';
        $is_voided = $data['obj']['is_voided'] ? 'true' : 'false';
        $cart = $data['obj']['order']['id'];
        $owner = $data['obj']['owner'];
        $pending = $data['obj']['pending'] ? 'true' : 'false';
        $source_data_pan = $data['obj']['source_data']['pan'];
        $source_data_sub_type = $data['obj']['source_data']['sub_type'];
        $source_data_type = $data['obj']['source_data']['type'];
        $success = $data['obj']['success'] ? 'true' : 'false';

        $string = $amount_cents . $created_at . $currency . $error_occured .
            $has_parent_transaction . $id . $integration_id . $is_3d_secure .
            $is_auth . $is_capture . $is_refunded . $is_standalone_payment .
            $is_voided . $cart . $owner . $pending .
            $source_data_pan . $source_data_sub_type . $source_data_type . $success;

        $hashed_string = hash_hmac('SHA512', $string, config('payment_paymob.hmac_secret'));
        return $hashed_string;
    }

    private function newCartPaymentRetry($old_cart_id)
    {
        try {
            DB::beginTransaction();
            $new_cart_id = $this->copyCart($old_cart_id);
            $old_cart = Cart::findOrFail($old_cart_id)->delete();
            DB::commit();
            return $this->payment_service->pay($new_cart_id);
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => 'error', 'message' => 'failed ' . $e->getMessage(),
                'error_code' => $e->getCode()];
        }
    }

    private function copyCart(int $cart_id): int
    {
        $old_cart = Cart::findOrFail($cart_id);

        $new_cart = Cart::create([
            'user_id' => $old_cart->user_id,
            'user_address_id' => $old_cart->user_address_id,
            'payment_id' => $old_cart->payment_id,
            'guest_user_id' => $old_cart->guest_user_id,
            'comment' => $old_cart->comment,
        ]);

        foreach ($old_cart->items as $item) {
            $cart_item = CartItem::create([
                'cart_id' => $new_cart->id,
                'shop_product_id' => $item->shop_product_id,
                'qty' => $item->qty,
            ]);
        }

        return $new_cart->id;
    }
}
