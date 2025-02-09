<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Vendor\ApproveAction;
use App\Actions\Admin\Vendor\DestroyAction;
use App\Actions\Admin\Vendor\StoreAction;
use App\Actions\Admin\Vendor\UpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Vendor\ApproveRequest;
use App\Http\Requests\Admin\Vendor\StoreRequest;
use App\Http\Requests\Admin\Vendor\UpdateRequest;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $main_title = 'Vendors';

        $sub_title = 'View';

        $count = Vendor::count('id');

        return view('Admin._vendors.index',
            compact('main_title', 'sub_title', 'count')
        );
    }

    //get assigned vendors data from DB, then return data in html table
    public function data()
    {
        $records = Vendor::all();

        return DataTables::of($records)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $main_title = 'Vendors';

        $sub_title = 'Add';

        return view('Admin._vendors.create', compact('main_title', 'sub_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, StoreAction $store_action)
    {
        DB::beginTransaction();

        try {
            $store_action->execute($request);

            DB::commit();

            session()->flash('_added', 'Vendor data has been created successfully');

            return redirect()->route('vendors.index');
        } catch (\Exception $exception) {
            DB::rollback();

            session()->flash('error', 'Vendor does not exist');

            return redirect()->route('vendors.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $main_title = 'Vendors';

        $sub_title = 'Edit';
        try {
            $vendor = Vendor::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Vendor does not exist');

            return redirect()->route('vendors.index');
        }

        return view('Admin._vendors.edit',
            compact('main_title', 'sub_title', 'vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateRequest $request, UpdateAction $update_action, $id)
    {
        try {
            Vendor::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Vendor does not exist');

            return redirect()->route('vendors.index');
        }

        DB::beginTransaction();

        try {
            $update_action->execute($request, $id);

            DB::commit();

            session()->flash('_added', 'Vendor data has been updated successfully');

            return redirect()->route('vendors.index');

        } catch (\Exception $exception) {
            DB::rollback();

            session()->flash('error', 'Error!');

            return redirect()->route('vendors.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, DestroyAction $destroy_action)
    {
        try {
            Vendor::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([], 101);
        }

        DB::beginTransaction();

        try {
            $destroy_action->execute($id);

            DB::commit();

            return response()->json(['id' => $id], 200);

        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json(['id' => $id], 101);
        }
    }

    /**
     * Approve vendor
     */
    public function approve(ApproveRequest $request, ApproveAction $approve_action)
    {
        try {
            Vendor::findOrFail($request->id);
        } catch (ModelNotFoundException $e) {
            return response()->json([], 101);
        }

        DB::beginTransaction();

        try {
            $approve_action->execute($request);

            DB::commit();

            return response()->json(['id' => $request->id], 200);

        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json(['error'], 101);
        }
    }
}
