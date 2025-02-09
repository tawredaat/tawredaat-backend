<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Requests\User\Api\TrackOrder\TrackOrderRequest;
use App\Http\Resources\OrderStatusResource;
use App\Models\Order;
use App\Models\OrderStatus;

class TrackOrderController extends BaseResponse
{
    public function __invoke(TrackOrderRequest $request)
    {
        try {
            $order = Order::findOrFail($request->order_id);
            $order_status = OrderStatus::findOrFail($order->order_status_id);

            return
                ['validator' => null, 'success' => 'Order Status',
                'errors' => null, 'object' => new OrderStatusResource($order_status)];
        } catch (\Exception$exception) {
            return ['validator' => null, 'success' => null,
                'errors' => $exception, 'object' => null];
        }

    }
}
