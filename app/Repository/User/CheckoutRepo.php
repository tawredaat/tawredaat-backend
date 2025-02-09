<?php

namespace App\Repository\User;

use App\Actions\Admin\Order\DecreaseShopProductQuantityAction;
use App\Actions\User\Cart\UpdateAddressWithDefaultAction;
use App\Http\Resources\Collections\PaymentsCollection;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\UserAddressResource;
use App\Jobs\Admin\Order\ReceivedJob as AdminReceivedJob;
use App\Jobs\User\Order\ReceivedJob;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Bundel;
use App\Models\ShopProduct;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }
    /**
     * View all Payment types.
     *
     * @return colloection of data
     */
    public function payments()
    {
        try {
            $payments = Payment::where('status', 1)->get();
            // dd($payments);
            $results['payments'] = new PaymentsCollection($payments);
            return $this->result = ['validator' => null, 'success' => 'All Payment Types', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    /**
     * Select Payment type and store it in cart .
     *
     * @return colloection of data
     */
    public function selectPayment($user)
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            $cart = Cart::with('items')->where('user_id', $user->id)->first();
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
    /**
     * Select user address and store it in cart .
     *
     * @return colloection of data
     */
    public function selectAddress($user)
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            $cart = Cart::with('items')->where('user_id', $user->id)->first();
            if (!$cart) {
                return $this->result = ['validator' => [__('home.userHasNoCart')], 'success' => null, 'errors' => null, 'object' => null];
            }

            $address = UserAddress::where('id', $request->input('address_id'))->where('user_id', $user->id)->first();
            if (!$address) {
                return $this->result = ['validator' => [__('home.addressNotBelongsToUser')], 'success' => null, 'errors' => null, 'object' => null];
            }

            $cart->user_address_id = $request->input('address_id');
            $cart->save();
            if (!$user->user_address_id) {
                $user->user_address_id = $request->input('address_id');
                $user->save();
            }
            DB::commit();
            $results['address'] = new UserAddressResource($cart->userAddress);
            return $this->result = ['validator' => null, 'success' => __('home.addressSelected'), 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function validateCart($user_id,
        UpdateAddressWithDefaultAction $update_address_with_default_action) {
        try {
            $cart = Cart::with('items')->where('user_id', $user_id)->first();

            if (!$cart) {
                return $this->result = ['validator' => [__('home.userHasNoCart')], 'success' => null, 'errors' => null, 'object' => null];
            }

            // set address
            $update_address_with_default_action->execute($cart);

            if (!$cart->userAddress) {
                return $this->result = ['validator' => [__('home.selectYourAddress')], 'success' => null, 'errors' => null, 'object' => null];
            }
            // dd($cart->user->full_name);
            if ($cart->payment_id == config('payment_paymob.online_card.payment_id', 3)
                && (!$cart->user->full_name)) {
                return $this->result = ['validator' => [__('home.add_your_name')],
                    'success' => null, 'errors' => null, 'object' => null];
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
     * @return collection of data
     */
    public function checkout($user)
    {
        DB::beginTransaction();

        try {
            $cart = Cart::with('allItems')->where('user_id', $user->id)->first();

            // $data = $cart->cartCalculation();
            // $subtotal = $data['subtotal'];
            // $total = $data['total'];
            // $discount = $data['discount'];
            // $promocode = $data['promocode'];
            // $deliveryCharge = $data['deliveryCharge'];
            // $address = $data['address'];
            
            $subTotal = 0;
            // $total = 0;
            foreach ($cart->allItems as $item) {
                // Retrieve the shop product price from the database
                $product = ShopProduct::find($item->shop_product_id);
                $price = $product->price; // Assuming each product has a price field
        
                // Check if the item has a bundelId and apply discount if necessary
                if (!is_null($item->bundel_id)) {
                    // Get the bundle details, for example discount percentage
                    $bundle = Bundel::find($item->bundel_id);
                    $discount = $bundle->discount_percentage; // Assuming you have this field in the bundle table
        
                    // Apply the discount
                    $discountedPrice = $price - ($price * ($discount / 100));
        
                    // Add the discounted price to the total
                    $subTotal += $discountedPrice * $item->qty;
                } else {
                    // Add the normal price to the total
                    $subTotal += $price * $item->qty;
                }
            }
            // $setting = Setting::first();
            $address = UserAddress::find($cart->user_address_id);
            $deliveryCharge = $address->city->shipping_fees;

            // $additiona_percentage = $cart->payment->additional_percentage;
        
            // if(($setting->free_shipping_amount >= $subTotal) && $deliveryCharge < 0)
            // {
            //     $total = $subTotal + (( $deliveryCharge + $subTotal) * ($additiona_percentage/100));
            // }else{
            //     $total = $subTotal + ($subTotal * ($additiona_percentage/100));
            // }
            
            $total = $cart->totalItemsAndBundels();
            //    Store cart data in order with status pending
            $order = Order::create([
                'subtotal' => $subTotal,
                'total' => $total,
                'purchaseAmount' => $total,
                'discount' => 0,
                'user_id' => $user->id,
                'order_status_id' => OrderStatus::where('id', 1)->first()->id,
                'address' => $address->city->name . $address->detailed_address,
                'user_address_id' => $cart->user_address_id,
                'promocode' => $cart->promocode ? $cart->promocode->code : '',
                'comment' => $cart->comment,
                'payment_id' => $cart->payment_id,
                'delivery_charge' => $deliveryCharge ? $deliveryCharge : 0,
                'order_from' => 'Web',
            ]);
            //    Store cart items data in order items data belongs to the new order
            foreach ($cart->allItems as $item) {
                $bundel = Bundel::where('id', $item->bundel_id)->first();
                if($bundel)
                {
                $item_price = ($item->shopProduct->new_price) * ((100 - $bundel->discount_percentage) / 100 );
                }else{
                $item_price = $item->shopProduct->new_price;
                }
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'shop_product_id' => $item->shop_product_id,
                    'bundel_id' => $item->bundel_id,
                    'quantity' => $item->qty,
                    'price' => $item_price,
                    'amount' => round($item->qty * $item_price, 2),
                    'purchaseQuantity' => $item->qty,
                ]);
            }
            $cart->order_id = $order->id;
            $cart->save();
            $cart->delete();

            // Store first order status history as pending status
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status_id' => OrderStatus::where('id', 1)->first()->id,
                'minutes' => 0,
            ]);
            $order_to_send_email = Order::toSendEmail()->find($order->id);
            
            $setting = Setting::first();
            $logo = $setting->site_logo;
            {{sendMail($order_to_send_email->user->email,$order_to_send_email->user->full_name,'تم استلام الطلب',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.order.received' ,$order_to_send_email);}}
            {{sendMail(config('global.used_sent_from_email', 'info@tawredaat.com'),"",' تم استلام الطلب جديد',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.admin.order.received' ,$order_to_send_email);}}

            //  $order_to_send_email = Order::toSendEmail()->find($order->id);
            // $order_job = (new ReceivedJob($order_to_send_email))->delay(\Carbon\Carbon::now()
            //         ->addSeconds(2));
            // $order_for_admin_job = (new AdminReceivedJob($order_to_send_email))
            //     ->delay(\Carbon\Carbon::now()->addSeconds(2));

            DB::commit();

            // dispatch($order_job);
            // dispatch($order_for_admin_job);

            $results['order'] = new OrderResource($order);
            return $this->result = ['validator' => null,
                'success' => __('home.orderSent'), 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    
    // public function checkout($user, DecreaseShopProductQuantityAction $decrease_shop_product_quantity_action , $request)
    // {
    //     $orderItems = $request->input('orderItems');
    //     $subTotal = 0;
    //     $total = 0;
    
    //     foreach ($orderItems as $item) {
    //         // Retrieve the shop product price from the database
    //         $product = ShopProduct::find($item['shopProductId']);
    //         $price = $product->price; // Assuming each product has a price field
    
    //         // Check if the item has a bundelId and apply discount if necessary
    //         if (!is_null($item['bundelId'])) {
    //             // Get the bundle details, for example discount percentage
    //             $bundle = Bundel::find($item['bundelId']);
    //             $discount = $bundle->discount_percentage; // Assuming you have this field in the bundle table
    
    //             // Apply the discount
    //             $discountedPrice = $price - ($price * ($discount / 100));
    
    //             // Add the discounted price to the total
    //             $subTotal += $discountedPrice * $item['quantity'];
    //         } else {
    //             // Add the normal price to the total
    //             $subTotal += $price * $item['quantity'];
    //         }
    //     }
    //     $setting = Setting::first();
    //     $address = UserAddress::find($request['address_id']);
    //     $deliveryCharge = $address->city->shipping_fees;

    //     if($setting->free_shipping_amount > $subTotal && $deliveryCharge < 0)
    //     {
            
    //         $total = $subTotal + $deliveryCharge;
    //     }else{
    //         $total = $subTotal;
    //     }

    //     DB::beginTransaction();

    //     try {
    //         $order = Order::create([
    //             'subtotal' => $subTotal,
    //             'total' => $total,
    //             'purchaseAmount' => $total,
    //             // 'discount' => $discount ?? 0,
    //             'user_id' => $user->id,
    //             'order_status_id' => OrderStatus::where('id', 1)->first()->id,
    //             'address' => $address->detailed_address,
    //             'user_address_id' => $request['address_id'],
    //             'promocode' => $request['promocode'] ? $request['promocode'] : '',
    //             'payment_id' => $request['payment_id'],
    //             'delivery_charge' => $deliveryCharge ? $deliveryCharge : 0,
    //             'order_from' => 'Web',
    //         ]);
    //         //    Store cart items data in order items data belongs to the new order
    //         foreach ($request['orderItems'] as $item) {
                
    //             $product = ShopProduct::find($item['shopProductId']);

    //             $item_price = $product->new_price;
    //             $orderItem = OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'shop_product_id' => $product->id,
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item_price,
    //                 'amount' => ($item['quantity'] * $item_price),
    //                 'purchaseQuantity' => $item['quantity'],
    //             ]);
    //         }


    //         // Store first order status history as pending status
    //         OrderStatusHistory::create([
    //             'order_id' => $order->id,
    //             'status_id' => OrderStatus::where('id', 1)->first()->id,
    //             'minutes' => 0,
    //         ]);
    //         $decrease_shop_product_quantity_action->execute($order->id);
    //         $order_to_send_email = Order::toSendEmail()->find($order->id);

    //         $setting = Setting::first();
    //         $logo = $setting->site_logo;
            
    //         {{sendMail($order_to_send_email->user->email,$order_to_send_email->user->name,'تم استلام الطلب',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.order.received' ,$order_to_send_email);}}
    //         {{sendMail(config('global.used_sent_from_email', 'info@tawredaat.com'),"",' تم استلام الطلب جديد',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.admin.order.received' ,$order_to_send_email);}}


    //         DB::commit();

    //         $results['order'] = new OrderResource($order);
    //         return $this->result = ['validator' => null,
    //             'success' => __('home.orderSent'), 'errors' => null, 'object' => $results];
    //     } catch (\Exception $exception) {
    //         dd($exception);
    //         DB::rollback();
    //         return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
    //     }
    // }

}
