<?php

namespace App\Repository\User;

use App\Actions\User\Cart\UpdateAddressWithDefaultAction;
use App\Http\Resources\Collections\PaymentsCollection;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\UserAddressResource;
use App\Jobs\SendOrderJob;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\ShopProduct;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestCheckoutRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Select Payment type and store it in cart .
     *
     * @return colloection of data
     */
    public function selectPayment($guest_user)
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            $cart = Cart::with('items')->where('guest_user_id', $guest_user->id)->first();
            if (!$cart) {
                return $this->result = ['validator' => [__('home.userHasNoCart')], 'success' => null, 'errors' => null, 'object' => null];
            }

            $cart->payment_id = $request->input('payment_id');
            $cart->save();
            DB::commit();
            $results['payment'] = new PaymentResource($cart->payment);
            return $this->result = ['validator' => null, 'success' => __('home.paymentSelected'), 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }


    public function validateCart($guest_user_id,
        UpdateAddressWithDefaultAction $update_address_with_default_action) {
        try {
            $cart = Cart::with('items')->where('guest_user_id', $guest_user_id)->first();
            if (!$cart || !count($cart->items)) {
                return $this->result = ['validator' => [__('home.userHasNoCart')], 'success' => null, 'errors' => null, 'object' => null];
            }

            // set address
            $update_address_with_default_action->execute($cart);

            if (!$cart->userAddress) {
                return $this->result = ['validator' => [__('home.selectYourAddress')], 'success' => null, 'errors' => null, 'object' => null];
            }

            if (!$cart->payment) {
                return $this->result = ['validator' => [__('home.selectPaymentType')], 'success' => null, 'errors' => null, 'object' => null];
            }

            return $this->result = ['validator' => null,
                'success' => 'Valid cart', 'errors' => null, 'object' => []];

        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    /**
     *Store  user order instance in DB.
     *
     * @return colloection of data
     */
    public function checkout($guest_user)
    {
        DB::beginTransaction();

        try {
            $cart = Cart::with('items')->where('guest_user_id', $guest_user->id)->first();

            $data = $cart->cartCalculation();
            $subtotal = $data['subtotal'];
            $total = $data['total'];
            $discount = $data['discount'];
            $promocode = $data['promocode'];
            $deliveryCharge = $data['deliveryCharge'];
            $address = $data['address'];
            //    Store cart data in order with status pending
            $order = Order::create([
                'subtotal' => $subtotal,
                'total' => $total,
                'purchaseAmount' => $total,
                'discount' => $discount,
                'guest_user_id' => $guest_user->id,
                'order_status_id' => OrderStatus::where('id', 1)->first()->id,
                'address' => $address,
                'user_address_id' => $cart->user_address_id,
                'promocode' => $cart->promocode ? $cart->promocode->code : '',
                'comment' => $cart->comment,
                'payment_id' => $cart->payment_id,
                'delivery_charge' => $deliveryCharge ? $deliveryCharge : 0,
                'order_from' => 'Web',
            ]);
            //    Store cart items data in order items data belongs to the new order
            foreach ($cart->items as $item) {
                $itme_price = $item->shopProduct->new_price;
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'shop_product_id' => $item->shop_product_id,
                    'quantity' => $item->qty,
                    'price' => $itme_price,
                    'amount' => round($item->qty * $itme_price, 2),
                    'purchaseQuantity' => $item->qty,
                ]);
            }

            $cart->delete();

            // Store first order status history as pending status
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status_id' => OrderStatus::where('id', 1)->first()->id,
                'minutes' => 0,
            ]);
            //place order mail

            $setting = Setting::first();
            $logo = $setting->site_logo;
            {{sendMail($order->user->email,$order->user->name,'Thank you for shopping on souqKahraba.com! ',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.OrderPlaced' ,$order);}}
    
    

            // $order_job = (new SendOrderJob($order))->delay(\Carbon\Carbon::now()->addSeconds(2));
            // dispatch($order_job);
            DB::commit();
            $results['order'] = new OrderResource($order);
            return $this->result = ['validator' => null, 'success' => __('home.orderSent'), 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

}