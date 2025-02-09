<?php
namespace App\Actions\User\UserAddress;

use App\Models\Cart;
use App\Models\UserAddress;

class SetAddressIdNullInCartAction
{
    public function execute($id)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->first();

        if (is_null($cart)) {
            return;
        }

        if ($cart->user_address_id != $id) {
            return;
        }

        if ($cart->user_address_id == $id) {
            $cart->update(['user_address_id' => null]);
        }

    }
}
