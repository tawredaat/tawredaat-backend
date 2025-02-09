<?php

namespace App\Actions\User\Cart;

use App\Models\Promocode;

class ApplyPromoCodeAction
{
    public function execute($promo_code_id, $cart): array
    {
        $subtotal = 0;
        $delivery_charge = 0;

        $delivery_charge = $cart->userAddress->city->shipping_fees;

        // get subtotal
        $cart_items = $cart->items;
        foreach ($cart_items as $cart_item) {
            $subtotal += $cart_item->shopProduct->new_price * $cart_item->qty;
        }

        $promo_code = Promocode::findOrFail($promo_code_id);

        return $promo_code->getDiscountValue($subtotal, $delivery_charge);
    }
}
