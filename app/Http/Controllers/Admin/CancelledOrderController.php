<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\DB;


class CancelledOrderController extends Controller
{

    public function index()
    {
        $MainTitle = 'Orders';
        $SubTitle = ' View';
        $statuses = OrderStatus::where('id','!=',1)->get();
        $orderStatuses = (object)$statuses->pluck('statusType','id')->toArray();
        return view('Admin._orders.cancelled.index', compact('MainTitle', 'SubTitle','orderStatuses'));
    }

    public function data(Request $request)
    {
        $orders = Order::where('cancelled',1)->when($request->input('column'), function ($query) use ($request) {

            if ($request->input('column') == 'payment_type')
                return $query->whereHas('payment', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            if ($request->input('column') == 'cancelled_by')
                return $query->whereHas('canceledBy', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('value') . '%');
            });

            if ($request->input('column') == 'user_id')
                return $query->whereHas('user', function ($query) use ($request) {
                    $query->where('id', 'like', '%' . $request->input('value') . '%');
                });
            if ($request->input('column') == 'user_name')
                return $query->whereHas('user', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });

            if ($request->input('column') == 'user_email')
                return $query->whereHas('user', function ($query) use ($request) {
                    $query->where('email', 'like', '%' . $request->input('value') . '%');
                });

            if ($request->input('column') == 'user_phone')
                return $query->whereHas('user', function ($query) use ($request) {
                    $query->where('phone', 'like', '%' . $request->input('value') . '%');
                });
        })->
        with(['user' => function ($query) {
            return $query->select(['id', 'name', 'email', 'phone']);
        }, 'payment' => function ($query) {
            return $query->with(['translations' => function ($query) {
                return $query->select(['name', 'payment_id', 'locale'])->where('locale', 'en');
            }])->select(['id']);
        }, 'items' => function ($query) {
            return $query->select(['id', 'order_id']);
        }])->select(['id','order_status_id', 'subtotal', 'total', 'discount', 'promocode', 'created_at', 'user_id', 'payment_id','cancelled','cancelled_by','cancelled_at'])
            ->when($request->input('column') == 'order_id', function ($query) use ($request) {
                return $query->where('id', 'like', '%' . $request->input('value') . '%');
            })
            ->when($request->input('column') == 'cancelled_at', function ($query) use ($request) {
                return $query->where('cancelled_at', 'like', '%' . $request->input('value') . '%');
            })
            ->when($request->input('column') == 'total', function ($query) use ($request) {
                return $query->where('total', 'like', '%' . $request->input('value') . '%');
            })
            ->when($request->input('column') == 'subtotal', function ($query) use ($request) {
                return $query->where('subtotal', 'like', '%' . $request->input('value') . '%');
            })
            ->when($request->input('column') == 'discount', function ($query) use ($request) {
                return $query->where('discount', 'like', '%' . $request->input('value') . '%');
            })
            ->when($request->input('column') == 'promocode', function ($query) use ($request) {
                return $query->where('promocode', 'like', '%' . $request->input('value') . '%');
            })
            ->when($request->input('column') == 'created_at', function ($query) use ($request) {
                return $query->where('created_at', 'like', '%' . $request->input('value') . '%');
            })
            ->orderBy('created_at', 'DESC')->paginate(10)->appends([
                'column' => $request->input('column'),
                'value' => $request->input('value'),
            ]);
        return response()->json(['result' => view('Admin._orders.cancelled.data', compact('orders'))->render(), 'links' =>  $orders->links()->render()], 200);
    }

    public function show($id)
    {
        $MainTitle = 'Order';
        $order = Order::where('cancelled',1)->findOrFail($id);
        $SubTitle = '#'.$order->id;
        return view('Admin._orders.cancelled.show', compact('MainTitle', 'SubTitle', 'order'));
    }

}
