<?php

namespace App\Actions\User\OnlineTransaction;

use App\Models\Order;

class UpdateOrderTransactionIdAction
{
    public function execute($order_id, $json)
    {
        $order = Order::findOrFail($order_id);
        return $order->update(['transaction_id' => $json['obj']['id']]);
    }
}
