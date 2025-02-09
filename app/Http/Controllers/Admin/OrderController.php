<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Order\AddProductAction;
use App\Actions\Admin\Order\DecreaseShopProductQuantityAction;
use App\Actions\Admin\Order\StoreAction;
use App\Actions\Admin\Order\StoreOrderItemsAction;
use App\Actions\Admin\Order\StoreOrderStatusHistoryAction;
use App\Actions\Admin\Order\UpdateAction;
use App\Actions\Admin\Order\UpdateOrderStatusHistoryAction;
use App\Actions\Admin\Order\UpdateTotalSubTotalAction;
use App\Actions\Admin\PromoCode\ApplyPromoCodeAction;
use App\Exports\ExportOrderDetailsData;
use App\Exports\ExportOrdersData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\AddProductRequest;
use App\Http\Requests\Admin\Order\StoreRequest;
use App\Http\Requests\Admin\Order\UpdateRequest;
use App\Jobs\User\Order\ConfirmingJob;
use App\Jobs\User\Order\DeliveredJob;
use App\Jobs\User\Order\PreparingJob;
use App\Jobs\User\Order\ShippedJob;
use App\Jobs\User\Order\UpdatedJob;
use App\Mail\OrderCanceledMail;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Promocode;
use App\Models\Setting;
use App\Models\ShopProduct;
use App\Models\UserAddress;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{

    public const EMAIL_DELAY_SECONDS = 1;

    public function index()
    {
        $MainTitle = 'Orders';
        $SubTitle = ' View';
        $statuses = OrderStatus::where('id', '!=', 1)->get();
        $orderStatuses = (object) $statuses->pluck('name', 'id')->toArray();
        return view('Admin._orders.index', compact('MainTitle', 'SubTitle', 'orderStatuses'));
    }

    public function filterData(Request $request)
    {
        return Order::where('cancelled', 0)->when($request->input('column'), function ($query) use ($request) {

            if ($request->input('column') == 'payment_type') {
                return $query->whereHas('payment', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            }

            if ($request->input('column') == 'user_id') {
                return $query->whereHas('user', function ($query) use ($request) {
                    $query->where('id', 'like', '%' . $request->input('value') . '%');
                });
            }

            if ($request->input('column') == 'status') {
                return $query->whereHas('status', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            }

            if ($request->input('column') == 'user_name') {
                return $query->whereHas('user', function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            }

            if ($request->input('column') == 'user_email') {
                return $query->whereHas('user', function ($query) use ($request) {
                    $query->where('email', 'like', '%' . $request->input('value') . '%');
                });
            }

            if ($request->input('column') == 'user_phone') {
                return $query->whereHas('user', function ($query) use ($request) {
                    $query->where('phone', 'like', '%' . $request->input('value') . '%');
                });
            }

        })->
            with(['user' => function ($query) {
            return $query->select(['id', 'name', 'email', 'phone']);
        }, 'status' => function ($query) {
            return $query->with(['translations' => function ($query) {
                return $query->select(['name', 'order_status_id', 'locale'])->where('locale', 'en');
            }])->select(['id', 'color']);
        }, 'payment' => function ($query) {
            return $query->with(['translations' => function ($query) {
                return $query->select(['name', 'payment_id', 'locale'])->where('locale', 'en');
            }])->select(['id']);
        }, 'items' => function ($query) {
            return $query->select(['id', 'order_id']);
        }])->select(['id', 'order_status_id', 'order_from', 'address', 'subtotal', 'total','delivery_charge', 'discount', 'promocode', 'created_at', 'user_id', 'payment_id'])
            ->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
                return $query->whereBetween('created_at', [Carbon::parse($request->input('start_date')), Carbon::parse($request->input('end_date'))]);
            })
            ->when($request->input('column') == 'order_id', function ($query) use ($request) {
                return $query->where('id', 'like', '%' . $request->input('value') . '%');
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
            });

    }

    public function data(Request $request)
    {

        $orders = $this->filterData($request)->orderBy('created_at', 'DESC')->paginate(10)->appends([
            'column' => $request->input('column'),
            'value' => $request->input('value'),
        ]);
        return response()->json(['result' => view('Admin._orders.data', compact('orders'))->render(), 'links' => $orders->links()->render()], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Order';
        $SubTitle = 'Add';

        $promo_codes = Promocode::select('id', 'code')->get();
        $users = User::select(['id', 'name', 'phone'])->get();
        $payments = Payment::select('id')->with('translations')->get();
        $products = ShopProduct::select('id')->with('translations')->get();

        return view('Admin._orders.create',
            compact('MainTitle', 'SubTitle', 'users', 'promo_codes', 'payments', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request,
        ApplyPromoCodeAction $apply_promo_code_action,
        StoreAction $store_action,
        DecreaseShopProductQuantityAction $decrease_shop_product_quantity_action,
        StoreOrderItemsAction $store_order_items_action,
        StoreOrderStatusHistoryAction $store_order_status_history_action) {
        DB::beginTransaction();

        try {
            // store order
            $order_id = $store_action->execute($request, $apply_promo_code_action);
            // store order items
            $store_order_items_action->execute($request, $order_id);
            // store order status history
            $store_order_status_history_action->execute($order_id, config('global.pending_order_status', 1));
            $decrease_shop_product_quantity_action->execute($order_id);
            DB::commit();

            session()->flash('_added', 'Order has been created successfully');
            return redirect()->route('orders.index');
        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('error', 'Cannot add. ' . $exception->getMessage());
            return redirect()->route('orders.index');
        }
    }

    public function show($id)
    {
        $MainTitle = 'Order';
        $order = Order::where('cancelled', 0)->findOrFail($id);
        $SubTitle = '#' . $order->id;
        $addresses = UserAddress::where('user_id', $order->user_id)->get();
        $promo_codes = Promocode::select('id', 'code')->get();
        $payments = Payment::select('id')->with('translations')->get();
        $products = ShopProduct::select('id')->with('translations')->get();

        return view('Admin._orders.show',
            compact('MainTitle', 'SubTitle', 'order', 'products', 'addresses',
                'promo_codes', 'payments'));
    }

    /**
     * Update a newly created resource in storage.
     */
    public function update(UpdateRequest $request,
        UpdateAction $update_action,
        ApplyPromoCodeAction $apply_promo_code_action,
        StoreOrderItemsAction $store_order_items_action,
        $id) {
        DB::beginTransaction();

        try {
            $order = Order::findOrFail($id);
            $old_order_items_data = $this->getOrderItemsData($order);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Order does not exist');
            return redirect()->route('orders.index');
        }

        try {
            // update order
            $updated_order = $update_action->execute($request, $apply_promo_code_action, $id);
            // store order items
            $store_order_items_action->execute($request, $id);
            $updated_order_items_data = $this->getOrderItemsData($updated_order);

            if ($this->isOrderChanged($old_order_items_data, $updated_order_items_data)) {
                $setting = Setting::first();
                $logo = $setting->site_logo;

            {{sendMail($order->user->email,$order->user->name,'تحديث الطلب',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.order.updated' ,$order);}}
           
                
                // $order_job = (new UpdatedJob($order))->delay(\Carbon\Carbon::now()
                //         ->addSeconds(self::EMAIL_DELAY_SECONDS));

                // dispatch($order_job);
            }

            DB::commit();
            session()->flash('_added', 'Order has been updated successfully');
            return redirect()->route('orders.index');
        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('error', 'Cannot add. ' . $exception->getMessage());
            return redirect()->route('orders.index');
        }
    }

    public function addProduct(AddProductRequest $request, AddProductAction $add_product_action,
        UpdateTotalSubTotalAction $update_order_action, $id) {

        try {
            $order = Order::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Order does not exist');
            return redirect()->route('orders.index');
        }

        DB::beginTransaction();

        try {
            $order_item = $add_product_action->execute($request, $id);
            $update_order_action->execute($order_item, $id);

            DB::commit();
            session()->flash('_added', 'Product has been added Successfully');
            return redirect()->route('orders.show', $id);
        } catch (\Exception $exception) {

            DB::rollback();
            session()->flash('error', 'Cannot add');
            return redirect()->route('orders.show', $id);

        }
    }

    public function cancel($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::where('order_status_id', OrderStatus::first()->id)->find($id);
            if ($order) {
                $order->cancelled = 1;
                $order->cancelled_by = auth('admin')->user()->id;
                $order->cancelled_at = date('Y-m-d H:i:s');
                $order->save();
                // cancel order mail
//                Mail::to($order->user->email)->send(new OrderCanceledMail($order));
                $setting = Setting::first();
                $logo = $setting->site_logo;
                dd($order->userAddress);
                sendMail($order->user->email, $order->user->name, 'We Received your RFQ Successfully. We will respond soon!',
                    $logo, config('global.used_app_name', 'Tawredaat'),'User.mails.OrderCanceled',$order);

                DB::commit();
                return ['validator' => null, 'success' => 'Order has been canceled successfuly !', 'errors' => null, 'item' => $order->id];
            }
            return ['validator' => 'You can not cancel this order  with status not pending !', 'success' => null, 'errors' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return ['validator' => null, 'success' => null, 'errors' => $exception];
        }
    }

    /**
     * change order status by admin
     * @param User\Models\Order $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request,
        UpdateOrderStatusHistoryAction $update_order_status_history_action,
        StoreOrderStatusHistoryAction $store_order_status_history_action, $id) {
        DB::beginTransaction();
        try {
            $order = Order::toSendEmail()->find($id);
            $old_status = $order->order_status_id;

            if ($order) {
                $orderStaus = OrderStatus::where('id', $request->input('status'))->first();
                if ($orderStaus) {
                    $order->order_status_id = $orderStaus ? $orderStaus->id : null;
                    $order->save();

                    $new_status = $order->order_status_id;

                    if ($old_status != $new_status) {
                        $update_order_status_history_action->execute($id);
                        $store_order_status_history_action->execute($id, $new_status);
                    }

                    // if ($new_status == config('global.delivered_order_status', 4)) {'
                    //     Mail::to($order->user->email)->send(new OrderDelivered($order));
                    // '} elseif ($new_status == config('global.pending_order_status', 1)) {
                    //     Mail::to($order->user->email)->send(new OrderReceived($order));
                    // } elseif ($new_status == config('global.confirming_order_status', 7)) {
                    //     Mail::to($order->user->email)->send(new OrderConfirming($order));
                    // } elseif ($new_status == config('global.preparing_order_status', 6)) {
                    //     Mail::to($order->user->email)->send(new OrderPreparing($order));
                    // } elseif ($new_status == config('global.shipped_order_status', 2)) {
                    //     Mail::to($order->user->email)->send(new OrderShipped($order));
                    // }

                    // $order_job = null;
                    $setting = Setting::first();
                    $logo = $setting->site_logo;
                    if ($new_status == config('global.delivered_order_status', 4)) {
                        {{sendMail($order->user->email,$order->user->name,' تم التوصيل',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.order.delivered_new' ,$order);}}
             
                        // $order_job = (new DeliveredJob($order))->delay(\Carbon\Carbon::now()
                        //         ->addSeconds(self::EMAIL_DELAY_SECONDS));
                    } elseif ($new_status == config('global.confirming_order_status', 7)) {
                        {{sendMail($order->user->email,$order->user->name,' تأكيد الطلب',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.order.confirming_new' ,$order);}}

                        // $order_job = (new ConfirmingJob($order))->delay(\Carbon\Carbon::now()
                        //         ->addSeconds(self::EMAIL_DELAY_SECONDS));
                    } elseif ($new_status == config('global.preparing_order_status', 6)) {
                        {{sendMail($order->user->email,$order->user->name,' جاري تحضير الطلب',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.order.preparing' ,$order);}}
                        
                        // $order_job = (new PreparingJob($order))->delay(\Carbon\Carbon::now()
                        //         ->addSeconds(self::EMAIL_DELAY_SECONDS));
                    } elseif ($new_status == config('global.shipped_order_status', 2)) {
                        {{sendMail($order->user->email,$order->user->name,' جاري شحن الطلب',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.order.shipped_new' ,$order);}}
                    } elseif ($new_status == config('global.shipped_order_status', 8)) {
                        {{sendMail($order->user->email,$order->user->name,' تم الغاء الطلب',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.order.cancelling_new',$order);}}

                        // $order_job = (new ShippedJob($order))->delay(\Carbon\Carbon::now()
                        //         ->addSeconds(self::EMAIL_DELAY_SECONDS));
                    }elseif($new_status == 5) 
                    {
                     	$event =  new DecreaseShopProductQuantityAction;
                        $event->execute($order->id);       
                    }
                    // if (!is_null($order_job)) {
                    //     dispatch($order_job);
                    // }

                    DB::commit();

                    return ['validator' => null,
                        'success' => 'Order statue has been changed successfully!',
                        'errors' => null, 'item' => $order->id];
                }
                return ['validator' => 'You can not change order to this status !', 'success' => null, 'errors' => null];
            }
            return ['validator' => 'You can not change order status while it pending !', 'success' => null, 'errors' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return ['validator' => null, 'success' => null,
                'errors' => $exception->getMessage()];
        }
    }

    public function export(Request $request)
    {
        try {
            $records = $this->filterData($request)->orderBy('id', 'DESC')->get();
            return Excel::download(new ExportOrdersData($records), 'orders_data.csv');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Error occured, Please try again later.');
        }
    }

    public function exportDetails(Request $request)
    {
        try {
            $record = Order::findOrFail($request->input('resourceId'));
            return Excel::download(new ExportOrderDetailsData($record), $record->id.'.csv');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Error occured, Please try again later.');
        }
    }

    public function getOrderItemsData($order)
    {
        return $order->items()->select('id', 'shop_product_id', 'quantity',
            'manual_product_name')->get()->toArray();
    }

    private function isOrderChanged($old_order_items, $updated_order_items): bool
    {
        if (count($old_order_items) != count($updated_order_items)) {
            return true;
        }

        $shop_product_ids_updated = (array_column($updated_order_items, 'shop_product_id'));
        $quantities_updated = (array_column($updated_order_items, 'quantity'));
        $manual_product_names_updated = (array_column($updated_order_items, 'manual_product_name'));

        foreach ($old_order_items as $key => $old_order_item) {
            $shop_product_id_old = $old_order_item['shop_product_id'];
            $quantity_old = $old_order_item['quantity'];
            $manual_product_name_old = $old_order_item['manual_product_name'];

            $product_index = array_search($shop_product_id_old, $shop_product_ids_updated);
            $manual_product_index = array_search($manual_product_name_old, $manual_product_names_updated);

            // the manual added product was not changed
            if (!is_null($manual_product_name_old) &&
                $manual_product_index !== false) {
                // quantity was changed
                if ($quantities_updated[$product_index] != $quantity_old) {
                    return true;
                }
            } else { // manual product was changed
                return true;
            }

            // old product was not updated
            if ($product_index !== false) {
                // check quantity for the same product_index
                if ($quantities_updated[$product_index] != $quantity_old) {
                    return true;
                }
            } else { // product was changed
                return true;
            }
        }
        return false;
    }
}