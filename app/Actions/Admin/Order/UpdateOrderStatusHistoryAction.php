<?php

namespace App\Actions\Admin\Order;

use App\Models\OrderStatusHistory;
use Carbon\Carbon;

class UpdateOrderStatusHistoryAction
{
    public function execute($order_id)
    {
        // add minutes and days to the previous order status history
        // set the days, minutes
        $last_order_status_history = OrderStatusHistory::where('order_id', $order_id)
            ->orderBy('created_at', 'DESC')->first();

        $from = Carbon::parse($last_order_status_history->created_at);

        $last_order_status_history->update([
            'days' => now()->diffInDays($from),
            'minutes' => now()->diffInMinutes($from)]);
    }
}
