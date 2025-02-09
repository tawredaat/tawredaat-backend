<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CategoryBanner\DestroyAction;
use App\Actions\Admin\CategoryBanner\StoreAction;
use App\Actions\Admin\CategoryBanner\UpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBennerRequest;
use App\Http\Requests\Admin\CategoryBanner\DestroyRequest;
use App\Http\Requests\Admin\CategoryBanner\StoreRequest;
use App\Http\Requests\Admin\CategoryBanner\UpdateRequest;
use App\Models\Category;
use App\Models\CategoryBanner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Helpers\UploadFile;

class CategoryBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category_id = $request->category_id; 

        try {
            $category = Category::findOrFail($category_id);
        } catch (ModelNotFoundException $e) {
                        dd($e);

            session()->flash('error', 'Category does not exist');

            return redirect()->route('categories.index');
        }

        $main_title = 'Category Banners ' . $category->name;

        $sub_title = 'View';

        return view('Admin._category_banners.index', compact(
            'main_title',
            'sub_title',
            'category_id'
        ));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function banners($category_id)
    { 
        $records = CategoryBanner::where('category_id', $category_id)->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $category_id = $request->category_id;

        try {
            $category = Category::findOrFail($category_id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Category does not exist');

            return redirect()->route('categories.index');
        }

        $main_title = 'Banners for ' . $category->name;

        $sub_title = 'Add';

        return view('Admin._category_banners.create', compact(
            'main_title',
            'sub_title',
            'category_id'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBennerRequest $request)
    {
        $input = $request->all();
        
        //upload new file
        $imgAr = $request->file('imgAr') ? UploadFile::UploadSinglelFile($request->file('imgAr'), 'category_banners') : null;
        $imgEn = $request->file('imgEn') ? UploadFile::UploadSinglelFile($request->file('imgEn'), 'category_banners') : null;
        $mob_imgAR = $request->file('mobileimgAr') ? UploadFile::UploadSinglelFile($request->file('mobileimgAr'), 'category_banners') : null;
        $mob_imgEn = $request->file('mobileimgEn') ? UploadFile::UploadSinglelFile($request->file('mobileimgEn'), 'category_banners') : null;
        
        DB::beginTransaction();
        try {
            CategoryBanner::create([
                'section' => $input['section'],
                'category_id' => $input['category_id'],
                'en' => [
                    'alt'       => $input['altEN'],
                    'image'     => $imgEn,
                    'mobile_image' => $mob_imgEn,
                    'url'       => $input['urlEn'],
                ],
                'ar' => [
                    'alt'       => $input['altAR'],
                    'image'     => $imgAr,
                    'mobile_image' => $mob_imgAR,
                    'url'       => $input['urlAr'],
                ],
            ]);
            
            DB::commit(); // Ensure the transaction is committed
            session()->flash('_added', 'Banner has been created successfully');
            return redirect()->route('category-banners.index', ['category_id' => $request->category_id]);
            
        } catch (\Exception $exception) {
            DB::rollback(); // Rollback the transaction if something goes wrong
            // Log the exception to troubleshoot further
            \Log::error('Error creating banner: '.$exception->getMessage());
            abort(500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $category_banner = CategoryBanner::findOrFail($id);
        } catch (ModelNotFoundException $e) {
                        dd($e);

            session()->flash('error', 'Category does not exist');

            return redirect()->back();
        }

        $main_title = 'Banners for ' . $category_banner->category->name;

        $sub_title = 'Edit';

        return view('Admin._category_banners.edit', compact('main_title', 'sub_title', 'category_banner'));
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
                'category-banners.index',
                ['category_id' => $request->category_id]
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

    public function makeHome($id)
    {
        $category_banner = CategoryBanner::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($category_banner->home== 1) {
                $category_banner->home = 0;
                $category_banner->save();
                DB::commit();
                return response()->json(['id' => $id, 'home' => $category_banner->home, 'success' => 'category_banner has been removed from home.']);
            } else {
                $category_banner->home = 1;
                $category_banner->save();
                DB::commit();
                return response()->json(['id' => $id, 'home' => $category_banner->home, 'success' => 'category_banner has been added to home.']);
            }
        } catch (\Exception$exception) {
            DB::rollback();
            abort(500);
        }
    }
}
