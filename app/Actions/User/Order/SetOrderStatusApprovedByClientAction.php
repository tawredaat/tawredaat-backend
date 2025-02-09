<?php

namespace App\Actions\User\Order;

use App\Models\Order;
use App\Models\OrderStatus;
use Exception;

class SetOrderStatusApprovedByClientAction
{
    public function execute($id)
    {
        $order = Order::where('user_id', auth('api')->user()->id)->findOrFail($id);

        // change status to client approved
        // find status id

        $status = OrderStatus::whereHas('translations', function ($query) {
            $query->where('name', 'Approved by Client')
                ->whereRaw('LOWER(`name`) LIKE ? ', [trim(strtolower(config('global.order_status_approved_by_client_name_en', 'Approved by Client'))) . '%'])
                ->where('locale', 'en');
        })->first();

        if (is_null($status)) {
            return new Exception('Error!');
        }

        $order->update([
            'order_status_id' => $status->id,
        ]);

        return $order;
    }
}
