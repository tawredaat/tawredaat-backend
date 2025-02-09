<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderStatusRequest;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class OrderstatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MainTitle = 'Order Status';
        $SubTitle = 'View';
        return view('Admin._order_statuses.index', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     *
     * @return Json Object
     */
    public function order_statues()
    {
        $records = OrderStatus::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $MainTitle = 'Order Status';
        $SubTitle = 'Add';
        return view('Admin._order_statuses.create', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStatusRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            OrderStatus::create([
                'color' => $input['color'],
                'en' => [
                    'name' => $input['name_en'],
                ],
                'ar' => [
                    'name' => $input['name_ar'],
                ],
                'is_active' => $request->has('is_active'),
            ]);
            DB::commit();
            session()->flash('_added', 'Order Status  Created Successfully');
            return redirect()->route('order_statuses.index');
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $MainTitle = 'Order Status';
        $SubTitle = 'Edit';
        $order_status = OrderStatus::findOrFail($id);
        return view('Admin._order_statuses.edit', compact('order_status', 'MainTitle', 'SubTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderStatusRequest $request, $id)
    {
        Db::beginTransaction();
        try {
            $order_status = OrderStatus::findOrFail($id);
            $order_status->translate('en')->name = $request->input('name_en');
            $order_status->translate('ar')->name = $request->input('name_ar');
            $order_status->color = $request->input('color');
            $order_status->is_active = $request->has('is_active');
            $order_status->save();
            DB::commit();
            session()->flash('_added', 'Order Status  edited Succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderStatus = OrderStatus::findOrFail($id);
        $orderStatus->delete();
        return response()->json([], 200);
    }
}
