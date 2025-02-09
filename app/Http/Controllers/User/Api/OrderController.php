<?php

namespace App\Http\Controllers\User\Api;

use App\Actions\User\Order\SetOrderStatusApprovedByClientAction;
use App\Mail\OrderStatusChangedMail;
use App\Models\Cart;
use App\Models\OnlineTransaction;
use App\Models\Order;
use App\Models\Setting;
use App\Repository\User\OrderRepo;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\OrderResource;

class OrderController extends BaseResponse
{

    protected $orderRepo;

    public function __construct(OrderRepo $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function view()
    {
        $result = $this->orderRepo->view(auth('api')->user());
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function show(Order $order)
    {
        $result = $this->orderRepo->show(auth('api')->user(), $order);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function showPaidOnline(Request $request)
    {
        try {
            $user_id = auth('api')->user()->id;
            $cart = Cart::onlyTrashed()->where('user_id', $user_id)
                ->paymentOnline()->select('id')->findOrFail($request->cart_id);

            $online_transaction = OnlineTransaction::select('id', 'cart_id', 'transaction_id')
                ->where('user_id', $user_id)
                ->where('cart_id', $cart->id)->firstOrFail();

            $order = Order::where('transaction_id', $online_transaction->transaction_id)
                ->where('user_id', $user_id)
                ->firstOrFail();

        } catch (ModelNotFoundException $e) {
            return $this->response(101, 'Validation Error', 200,
                [__('validation.not_found')]);
        }

        $result = $this->orderRepo->show(auth('api')->user(), $order);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }
    
    public function viewOrderPaidDetails($order_id)
    {
        try {
            $user_id = auth('api')->user()->id;
            $cart = Cart::withTrashed()->where('id', $order_id)->first();

            $order = Order::where('id', $cart->order_id)
                ->first();
        } catch (ModelNotFoundException $e) {
            return $this->response(101, 'Validation Error', 200,
                [__('validation.not_found')]);
        }

        $result = new OrderResource($order);
        return $this->response(200, 'sucess', 200, [], 0, $result);
    }

    public function clientApprovedOrder($id,
        SetOrderStatusApprovedByClientAction $order_status_waiting_for_client_approval_mail
    ) {

        try {
            $order = Order::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->response(500, 'Order does not exists', 500);
        }

        try {
            DB::beginTransaction();

            $old_status = $order->order_status_id;

            $order = $order_status_waiting_for_client_approval_mail->execute($id);

            DB::commit();

            $new_status = $order->order_status_id;

            // check if the order status has been changed to avoid sending the emil on every click
            if ($old_status != $new_status) {
                $setting = Setting::first();
                $logo = $setting->site_logo;
                {{sendMail($order->user->email,$order->user->name,'Welcome to Souqkahraba.com!',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.order_status_changed' ,$order);}}
    
                // Mail::to($order->user->email)->send(new OrderStatusChangedMail($order));
            }

            return $this->response(200, 'Your response is saved', 200, [], 0, []);

        } catch (\Exception $ex) {
            DB::rollBack();

            return $this->response(500, 'Error!' . $ex->getMessage(), 500);

        }
    }
}
