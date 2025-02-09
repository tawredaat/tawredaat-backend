<?php

namespace App\Actions\Admin\Order;

use App\Models\OrderStatusHistory;

class StoreOrderStatusHistoryAction
{
    public function execute($order_id, $status_id)
    {
        // add minutes and days to the previous order status history

        // $last_order_status_history = OrderStatusHistory::where('order_id', $id)
        //     ->orderBy('created_at', 'DESC')->first();

        // create new record
        OrderStatusHistory::create([
            'order_id' => $order_id,
            'status_id' => $status_id,
            'minutes' => 0,
        ]);

    }
}
