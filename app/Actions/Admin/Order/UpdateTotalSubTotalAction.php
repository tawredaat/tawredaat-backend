<?php

namespace App\Actions\Admin\Order;

use App\Models\Order;
use App\Models\OrderItem;

class UpdateTotalSubTotalAction
{
    public function execute(OrderItem $order_item, $id)
    {
        $order = Order::findOrFail($id);

        // store fields
        $order->update([
            'total' => $order->total + $order_item->amount,
            'subtotal' => $order->total + $order_item->amount,
        ]);
    }
}
