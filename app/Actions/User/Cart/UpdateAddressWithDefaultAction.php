<?php
namespace App\Actions\User\Cart;

use App\Models\Cart;
use App\Models\UserAddress;

class UpdateAddressWithDefaultAction
{
    public function execute($cart)
    {
        // set address
        $default_address = UserAddress::where('user_id', $cart->user_id)
            ->where('is_default', 1)->first();
        if (!is_null($default_address)) {
            $cart->update(['user_address_id' => $default_address->id]);
        }
    }
}
