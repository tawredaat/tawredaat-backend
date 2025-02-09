<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CategoryBrandStorePage\DestroyAction;
use App\Actions\Admin\CategoryBrandStorePage\StoreAction;
use App\Actions\Admin\CategoryBrandStorePage\UpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryBrandStorePage\StoreRequest;
use App\Http\Requests\Admin\CategoryBrandStorePage\UpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrandStorePage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CategoryBrandStorePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $main_title = 'Control categories brands in the brands store page';
        $sub_title = 'View';
        $count = CategoryBrandStorePage::count('id');
        return view('Admin._categories_brands_store_page.index',
            compact('main_title', 'sub_title', 'count')
        );
    }

    public function data()
    {
        $grouped_by_category_ids = CategoryBrandStorePage::groupBy('category_id')
            ->select('id', 'category_id', 'brand_id')->get();
        $count = count($grouped_by_category_ids);
        $i = 0;
        foreach ($grouped_by_category_ids as $grouped_by_category_id) {
            $category = Category::findOrFail($grouped_by_category_id->category_id);
            $brands_ids = CategoryBrandStorePage::where('category_id', $category->id)
                ->pluck('brand_id')->toArray();

            $brands = Brand::whereIn('id', $brands_ids)->select('id')->with(['translation' => function ($query) {
                $query->select('id', 'brand_id', 'name');
            }])->get();

            $brands_names = "";
            $brands_count = count($brands);
            foreach ($brands as $key => $brand) {
                if ($key == $brands_count - 1) {
                    $brands_names .= $brand->name . '.';
                } else {
                    $brands_names .= $brand->name . ', ';
                }
            }

            $data[$i]['id'] = $category->id;
            $data[$i]['category_name'] = $category->name;
            $data[$i]['brands_names'] = $brands_names;

            $i++;
        }

        return DataTables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $main_title = 'Control categories brands in the brands store page';
        $sub_title = 'Add';

        $categories = Category::select('id')->with(['translation' => function ($query) {
            $query->select('id', 'category_id', 'name');
        }])->get();
        $brands = Brand::select('id')->with(['translation' => function ($query) {
            $query->select('id', 'brand_id', 'name');
        }])->get();

        return view('Admin._categories_brands_store_page.create',
            compact('main_title', 'sub_title', 'categories', 'brands'));
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
            session()->flash('_added', 'Data has been created successfully');
            return redirect()->route('categories-brands-store-pages.index');
        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('error', 'Cannot add');
            return redirect()->route('categories-brands-store-pages.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($category_id)
    {
        $main_title = 'Control categories brands in the brands store page';
        $sub_title = 'Edit';
        try {
            $category_brand_store_page = CategoryBrandStorePage::where('category_id',
                $category_id)->firstOrFail();
            $selected_category = Category::findOrFail($category_id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Does not exist');
            return redirect()->route('categories-brands-store-pages.index');
        }

        $selected_brands = CategoryBrandStorePage::where('category_id',
            $category_brand_store_page->category_id)->pluck('brand_id')->toArray();
        $categories = Category::select('id')->with(['translation' => function ($query) {
            $query->select('id', 'category_id', 'name');
        }])->get();

        $brands = Brand::select('id')->with(['translation' => function ($query) {
            $query->select('id', 'brand_id', 'name');
        }])->get();

        return view('Admin._categories_brands_store_page.edit',
            compact('main_title', 'sub_title', 'category_brand_store_page', 'categories', 'brands', 'selected_brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateRequest $request, UpdateAction $update_action, $id)
    {
        try {
            CategoryBrandStorePage::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Does not exist');
            return redirect()->route('categories-brands-store-pages.index');
        }

        DB::beginTransaction();

        try {
            $update_action->execute($request, $id);
            DB::commit();
            session()->flash('_added', 'Data has been updated successfully');
            return redirect()->route('categories-brands-store-pages.index');
        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('error', 'Error!');
            return redirect()->route('categories-brands-store-pages.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category_id, DestroyAction $destroy_action)
    {
        try {
            $category_brand_store_page = CategoryBrandStorePage::where('category_id',
                $category_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json([], 101);
        }

        DB::beginTransaction();

        try {
            $destroy_action->execute($category_brand_store_page->id);
            DB::commit();
            return response()->json(['id' => 0], 204);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['id' => $category_brand_store_page->id], 101);
        }
    }
}
