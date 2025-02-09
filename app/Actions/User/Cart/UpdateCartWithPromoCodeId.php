<?php

namespace App\Actions\User\Cart;

class UpdateCartWithPromoCodeId
{
    public function execute($promo_code_id, $cart): bool
    {
        return $cart->update(['promocode_id' => $promo_code_id]);
    }
}
