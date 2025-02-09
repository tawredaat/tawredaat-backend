<?php

namespace App\Actions\Admin\Order;

use App\Actions\Admin\PromoCode\ApplyPromoCodeAction;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Promocode;
use App\Models\ShopProduct;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;

class StoreAction
{
    public function execute(Request $request, ApplyPromoCodeAction $apply_promo_code_action)
    {
        $subtotal = 0;
        $discount = 0;
        $promo_code = "";
        $address = null;

        $products = $request->product_id;
        $manual_products = $request->manual_product_name;
        $prices = $request->price;
        $products_count = count($request->product_id);
        $quantities = $request->quantity;

        for ($i = 0; $i < $products_count; $i++) {
            if (is_null($products[$i])) {
                if (is_null($manual_products[$i])) {
                    throw new Exception('No product chosen or entered manually');
                }

                if (is_null($prices[$i])) {
                    throw new Exception('Price must be added with manually added products');
                }

                $subtotal += $prices[$i] * $quantities[$i];
            } else {
                $product = ShopProduct::findOrFail($products[$i]);

                $subtotal += $product->new_price * $quantities[$i];
            }
        }

        $total = round($subtotal, 2);

        $user_address = UserAddress::findOrFail($request->address_id);

        $delivery_charge = 0;

        if ($user_address->city) {
            $delivery_charge = $user_address->city->shipping_fees;
        }

        // apply promo code to get new total, discount, delivery_charge
        if (!is_null($request->promo_code_id)) {
            $promo_code = Promocode::findOrFail($request->promo_code_id);

            // get new delivery charge, discount
            $promo_code_data =
            $apply_promo_code_action->execute($request->promo_code_id, $total);

            $discount = $promo_code_data['discount'];

            if (!is_null($promo_code_data['delivery_charge'])) {
                $delivery_charge = $promo_code_data['delivery_charge'];
            }

            $promo_code = $promo_code->code;
        }

        $total = $subtotal + $delivery_charge - $discount;

        // set address

        $address_country = $user_address->country ? $user_address->country->name : "";
        $address_area = $user_address->area;
        $address_street = $user_address->street;
        $address_building = $user_address->building;
        $address_landmark = $user_address->landmark;

        $address = $address_country . ', ' . $address_area . ', ' . $address_street . ', ' . $address_building . ', ' . $address_landmark;

        $order = Order::create([
            'subtotal' => $subtotal,
            'total' => $total,
            'purchaseAmount' => $total,
            'discount' => $discount,
            'user_id' => $request->user_id,
            'order_status_id' => OrderStatus::where('id', 1)->first()->id,
            'address' => $address,
            'user_address_id' => $request->address_id,
            'promocode' => $promo_code,
            'comment' => $request->comment,
            'payment_id' => $request->payment_id,
            'delivery_charge' => $delivery_charge ? $delivery_charge : 0,
            'order_from' => $request->order_from,
        ]);

        return $order->id;
    }
}
