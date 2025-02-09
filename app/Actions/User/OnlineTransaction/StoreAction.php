<?php

namespace App\Actions\User\OnlineTransaction;

use App\Models\OnlineTransaction;

class StoreAction
{
    public function execute($user_id, $data, $paid)
    {
        return OnlineTransaction::create([
            'cart_id' => $data['obj']['order']['merchant_order_id'],
            'user_id' => $user_id,
            'transaction_id' => $data['obj']['id'],
            'amount' => $data['obj']['amount_cents'] / 100,
            // paymob order id
            'order' => $data['obj']['order']['id'],
            'transaction_type' => $data['type'],
            'paid' => $paid,
            'message' => $data['obj']['data']['message'],
        ]);

    }
}
