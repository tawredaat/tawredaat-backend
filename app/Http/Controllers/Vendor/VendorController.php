<?php

namespace App\Http\Controllers\Vendor;

use App\Actions\Vendor\Vendor\UpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Vendor\UpdateRequest;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $main_title = 'Your information';

        $sub_title = 'Edit your information';

        try {
            $vendor = Vendor::findOrFail(Auth('vendor')->user()->id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Vendor does not exist');

            return redirect()->route('vendor.vendors.index');
        }

        return view('Vendor.vendors.edit',
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

            return redirect()->route('vendor.vendors.edit');
        }

        DB::beginTransaction();

        try {
            $update_action->execute($request, $id);

            DB::commit();

            session()->flash('_added', 'Data has been updated successfully');

            return redirect()->route('vendor.vendors.edit');

        } catch (\Exception $exception) {
            DB::rollback();

            session()->flash('error', 'Error!');

            return redirect()->route('vendor.vendors.edit');
        }
    }

}
