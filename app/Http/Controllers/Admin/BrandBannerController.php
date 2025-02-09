<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\BrandBanner\DestroyAction;
use App\Actions\Admin\BrandBanner\StoreAction;
use App\Actions\Admin\BrandBanner\UpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandBanner\DestroyRequest;
use App\Http\Requests\Admin\BrandBanner\StoreRequest;
use App\Http\Requests\Admin\BrandBanner\UpdateRequest;
use App\Models\Brand;
use App\Models\BrandBanner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class BrandBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brand_id = $request->brand_id;

        try {
            $brand = Brand::findOrFail($brand_id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Brand does not exist');

            return redirect()->route('brands.index');
        }

        $main_title = 'Brand Banners ' . $brand->name;

        $sub_title = 'View';

        return view('Admin._brand_banners.index', compact(
            'main_title',
            'sub_title',
            'brand_id'
        ));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function banners($brand_id)
    {
        $records = BrandBanner::where('brand_id', $brand_id)->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $brand_id = $request->brand_id;

        try {
            $brand = Brand::findOrFail($brand_id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Brand does not exist');

            return redirect()->route('brands.index');
        }

        $main_title = 'Banners for' . $brand->name;

        $sub_title = 'Add';

        return view('Admin._brand_banners.create', compact(
            'main_title',
            'sub_title',
            'brand_id'
        ));
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
            session()->flash('_added', 'Banner has been created successfully');
            return redirect()->route('brand-banners.index', ['brand_id' => $request->brand_id]);
        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('error', 'Cannot add');
            return redirect()->route('brand-banners.index', ['brand_id' => $request->brand_id]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $brand_banner = BrandBanner::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Brand does not exist');

            return redirect()->back();
        }

        $main_title = 'Banners for ' . $brand_banner->brand->name;

        $sub_title = 'Edit';

        return view('Admin._brand_banners.edit', compact('main_title', 'sub_title', 'brand_banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateRequest $request, UpdateAction $update_action, $id)
    {
        DB::beginTransaction();
        try {
            $update_action->execute($request, $id);

            DB::commit();
            session()->flash('_updated', 'Banner has been updated successfully');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('error', 'Cannot add');
            return redirect()->route(
                'brand-banners.index',
                ['brand_id' => $request->brand_id]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyRequest $request, DestroyAction $destroy_action, $id)
    {
        DB::beginTransaction();

        try {
            $destroy_action->execute($id);
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['error' => 'Cannot delete']);
        }
    }
}
