<?php

namespace App\Repository\User;

use App\Http\Resources\Collections\OrdersCollection;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class OrderRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Show user orders..
     *
     * @param  $user
     * @return $result
     */
    public function view($user)
    {
        try {
            $results['orders'] = new OrdersCollection($user->orders);
            return $this->result = ['validator' => null, 'success' => 'User Orders list', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    /**
     * Show  order details..
     *
     * @param  $user
     * @param  $order
     * @return $result
     */
    public function show($user, $order)
    {
        try {
            if ($order->user_id == $user->id) {
                $results['order'] = new OrderResource($order);
                return $this->result = ['validator' => null, 'success' => 'Order Details', 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => ['This order is not found!'], 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
}
