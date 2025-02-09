<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\BrandStoreBanner\StoreAction;
use App\Actions\Admin\BrandStoreBanner\UpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandStoreBanner\StoreRequest;
use App\Http\Requests\Admin\BrandStoreBanner\UpdateRequest;
use App\Models\BrandStoreBanner;
use Illuminate\Support\Facades\DB;

class BrandStoreBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand_store_banner = BrandStoreBanner::first();
        if ($brand_store_banner) {
            $main_title = 'BrandStoreBanners';
            $sub_title = 'Edit';
            return view('Admin._brand_stores_banners.edit', compact('main_title', 'sub_title', 'brand_store_banner'));
        }
        $main_title = 'Brand Store Banners';
        $sub_title = 'Create';
        return view('Admin._brand_stores_banners.create', compact('main_title', 'sub_title'));
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
            session()->flash('_added', 'Website brand_stores has been saved successfully');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }

    }

    /**
     * update a resource in storage.
     */
    public function update(UpdateRequest $request, UpdateAction $update_action, $id)
    {
        DB::beginTransaction();
        try {
            $update_action->execute($request, $id);
            DB::commit();
            session()->flash('_added', 'Website brand stores has been saved Successfully');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

}
