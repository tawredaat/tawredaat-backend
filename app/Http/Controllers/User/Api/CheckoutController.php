<?php

namespace App\Http\Controllers\User\Api;

use App\Actions\Admin\Order\DecreaseShopProductQuantityAction;
use App\Actions\User\Cart\UpdateAddressWithDefaultAction;
use App\Actions\User\GuestUser\StoreAction;
use App\Http\Requests\User\Api\SelectAddressRequest;
use App\Http\Requests\User\Api\SelectPaymentRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\GuestUser;
use App\Repository\User\CheckoutRepo;
use App\Repository\User\CartRepo;
use App\Repository\User\GuestCheckoutRepo;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CheckoutController extends BaseResponse
{
    protected $checkoutRepo;
    protected $guest_checkout_repo;
    protected $guest_store_action;
    protected $cartRepo;

    public function __construct(CheckoutRepo $checkoutRepo, GuestCheckoutRepo $guest_checkout_repo, CartRepo $cartRepo,
        StoreAction $guest_store_action) {
        $this->checkoutRepo = $checkoutRepo;
        $this->guest_checkout_repo = $guest_checkout_repo;
        $this->guest_store_action = $guest_store_action;
        $this->cartRepo = $cartRepo;
    }

    public function viewPayments()
    {
        $result = $this->checkoutRepo->payments();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function selectPayment(SelectPaymentRequest $request)
    {
        // $user = User::getUser($request);

        // if ($user) {
        //     $this->checkoutRepo->setReq($request);
        //     $result = $this->checkoutRepo->selectPayment(auth('api')->user());
        // } else {
        //     $this->guest_checkout_repo->setReq($request);
        //     $guest_user = $this->getGuestUser($request->guest_user_id);
        //     if (is_null($guest_user)) {
        //         return $this->response(500, __('validation.error'), 500);
        //     }
        //     $result = $this->guest_checkout_repo->selectPayment($guest_user);
        // }

        $user = User::getUser($request);
        if (!$user) {
            return $this->response(101, "Validation Error", 200, 'You must register an account');
        }

        $this->checkoutRepo->setReq($request);
        $result = $this->checkoutRepo->selectPayment(auth('api')->user());

        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function selectAddress(SelectAddressRequest $request)
    {
        $this->checkoutRepo->setReq($request);
        $result = $this->checkoutRepo->selectAddress(auth('api')->user());
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    // public function checkout(UpdateAddressWithDefaultAction $update_address_with_default_action,
    //     DecreaseShopProductQuantityAction $decrease_shop_product_quantity_action) {
    //     $user_id = auth('api')->user()->id;

    //     // 1. validate cart
    //     $result = $this->checkoutRepo->validateCart($user_id,
    //         $update_address_with_default_action);

    //     if ($result['success']) {
    //         $cart = Cart::where('user_id', $user_id)->select('id', 'payment_id')->first();

    //         // checkout (create the database entries)
    //         if ($cart->payment_id == config('payment_paymob.online_card.payment_id', 3) ||
    //             $cart->payment_id == config('payment_paymob.valu.payment_id', 2)) {
    //             $results['cart'] = new CartResource($cart);
    //             return $this->response(200, $result['success'] . ' get the payment URL',
    //                 200, [], 0, ['cart' => $cart]);
    //         }

    //         $result = $this->checkoutRepo->checkout(auth('api')->user(), $decrease_shop_product_quantity_action);

    //         if ($result['success']) {
    //             return $this->response(200, $result['success'], 200, [], 0, $result['object']);
    //         } elseif ($result['validator']) {
    //             return $this->response(101, "Validation Error", 200, $result['validator']);
    //         } elseif ($result['errors']) {
    //             return $this->response(500, $result['errors'], 500);
    //         } else {
    //             return $this->response(500, "Error", 500);
    //         }

    //         // else

    //     } elseif ($result['validator']) {
    //         return $this->response(101, "Validation Error", 200, $result['validator']);
    //     } elseif ($result['errors']) {
    //         return $this->response(500, $result['errors'], 500);
    //     } else {
    //         return $this->response(500, "Error", 500);
    //     }
    // }
    
    public function checkout(UpdateAddressWithDefaultAction $update_address_with_default_action,
        DecreaseShopProductQuantityAction $decrease_shop_product_quantity_action , Request $request) {
        $user_id = auth('api')->user()->id;
        $user = auth('api')->user();
        $cart = Cart::where('user_id', $user->id)->first();
        if($cart)
        {
            $cart->delete();
        }
        $result = $this->cartRepo->store($user,$update_address_with_default_action ,$request);
        
        if($result['validator'])
        {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        }

        // 1. validate cart
        $result = $this->checkoutRepo->validateCart($user_id,
            $update_address_with_default_action);

        if ($result['success']) {
            $cart = Cart::where('user_id', $user_id)->select('id', 'payment_id')->first();
            // checkout (create the database entries)
            if (
                $cart->payment_id == config('payment_paymob.online_card.payment_id', 3) ||
                $cart->payment_id == config('payment_paymob.valu.payment_id', 2) ||
                $cart->payment_id == 4
            ) {
                $results['cart'] = new CartResource($cart);
                return $this->response(200, $result['success'] . ' get the payment URL',
                    200, [], 0, ['cart' => $cart]);
            }

            $result = $this->checkoutRepo->checkout(auth('api')->user());

            if ($result['success']) {
                return $this->response(200, $result['success'], 200, [], 0, $result['object']);
            } elseif ($result['validator']) {
                return $this->response(101, "Validation Error", 200, $result['validator']);
            } elseif ($result['errors']) {
                return $this->response(500, $result['errors'], 500);
            } else {
                return $this->response(500, "Error", 500);
            }

            // else

        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }

    // public function checkout(Request $request) {
        
    //         $user_id = auth('api')->user()->id;
            
    //         // Step 1: Define validation rules
    //         $validator = Validator::make($request->all(), [
    //         'orderItems' => 'required|array|min:1', // orderItems must be an array and at least one item should be there
    //         'orderItems.*.shopProductId' => 'required|integer|exists:shop_products,id', // shopProductId must exist in shop_products table
    //         'orderItems.*.quantity' => 'required|integer|min:1', // Quantity should be at least 1
    //         'payment_id' => 'required|integer|exists:payments,id', // Ensure payment_id exists in payments table
    //         'address_id' => [
    //             'required',
    //             'integer',
    //             Rule::exists('user_addresses', 'id')->where(function ($query) use ($user_id) {
    //                 $query->where('user_id', $user_id); // Check that the address belongs to the authenticated user
    //                 })
    //             ]
    //         ]);
        
    //         // Step 2: Check if validation fails
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 101,
    //                 'message' => 'Validation Error',
    //                 'errors' => $validator->errors()
    //             ], 400);
    //         }
    
    //         // checkout (create the database entries)
    //         if ($request['payment_id'] == config('payment_paymob.online_card.payment_id', 3) ||
    //             $request['payment_id'] == config('payment_paymob.valu.payment_id', 2)) {
    //             return $this->response(200, 'get the payment URL',
    //                 200, [], 0, ['cart' => $request]);
    //         }
            
    //         $decreaseShopProductQuantityAction = new DecreaseShopProductQuantityAction();
    //         $result = $this->checkoutRepo->checkout(auth('api')->user(), $decreaseShopProductQuantityAction , $request);

    //         if ($result['success']) {
    //             return $this->response(200, $result['success'], 200, [], 0, $result['object']);
    //         } elseif ($result['validator']) {
    //             return $this->response(101, "Validation Error", 200, $result['validator']);
    //         } elseif ($result['errors']) {
    //             return $this->response(500, $result['errors'], 500);
    //         } else {
    //             return $this->response(500, "Error", 500);
    //         }
    // }
    
    private function getGuestUser($guest_user_id)
    {
        if (is_null($guest_user_id)) {
            // create guest user
            DB::beginTransaction();
            try {
                $guest_user = $this->guest_store_action->execute($guest_user_id);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollback();
                return null;
            }

        } else {
            $guest_user = GuestUser::where('id', $guest_user_id)->first();
        }
        return $guest_user;
    }
}
