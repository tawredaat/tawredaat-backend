<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Category\DestroyLevel1Action;
use App\Actions\Admin\Category\StoreLevel1CategoryAction;
use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Models\BrandTranslation;
use App\Models\CategoryHomeBrand;
use App\Models\Brand;
use App\Models\CategoryTranslation;
use App\Models\CategoryHomeCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Categories';
        $SubTitle = 'View|Parents|level 1';
        return view('Admin._categories.index', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Display a listing of the resource (categories l1) in DT.
     */
    public function level1s()
    {
        $records = Category::whereNull('parent')->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Display a listing of the resource (categories l2) in DT.
     */
    public function level2s($id)
    {
        $MainTitle = 'Categories';
        $SubTitle = 'View|Level 2';
        $categories = Category::where('parent', $id)->where('level', 'level2')->get();
        return view('Admin._categories.level2s', compact('categories', 'MainTitle', 'SubTitle'));
    }
    /**
     * Display a listing of the resource (categories l3) in DT.
     */
    public function level3s($id)
    {
        $MainTitle = 'Categories';
        $SubTitle = 'View|Level 3';
        $categories = Category::where('parent', $id)->where('level', 'level3')->get();
        return view('Admin._categories.level3s', compact('categories', 'MainTitle', 'SubTitle'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $level1 = Category::with('childs')->where('level', 'level1')->get();
        $MainTitle = 'Categories';
        $SubTitle = 'Add';
        return view('Admin._categories.create', compact('MainTitle', 'SubTitle', 'level1'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $level = 'level1';
        if ($request->file('image')) {
            $img = UploadFile::UploadSinglelFile($request->file('image'), 'categories');
        } else {
            $img = null;
        }

        if ($request->parent) {
            $parent = Category::find($request->parent);
            if ($parent->parent) {
                $level = 'level3';
            } else {
                $level = 'level2';
            }
        }
        $input = $request->all();

        DB::beginTransaction();
        try {
            $category = Category::create([
                'parent' => $input['parent'] ?? null,
                'level' => $level,
                'image' => $img,
                'en' => [
                    'name' => $input['name_en'],
                    'title' => $input['title_en'],
                    'alt' => $input['alt_en'],
                    'description' => $input['descri_en'],
                    'description_meta' => $input['descri_meta_en'],
                    'keywords_meta' => $input['keywords_meta_en'],
                    'keywords' => $input['keywords_en'],

                ],
                'ar' => [
                    'name' => $input['name_ar'],
                    'title' => $input['title_ar'],
                    'alt' => $input['alt_ar'],
                    'description' => $input['descri_ar'],
                    'description_meta' => $input['descri_meta_ar'],
                    'keywords_meta' => $input['keywords_meta_ar'],
                    'keywords' => $input['keywords_ar'],

                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Category has been created successfully');
            if ($category->level == 'level1') {
                return redirect()->route('categories.index');
            } elseif ($category->level == 'level2') {
                return redirect()->route('category.categories.level2s', $category->parent);
            } else {
                return redirect()->route('category.categories.level3s', $category->parent);
            }
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createLevel1()
    {
        $MainTitle = 'Categories';
        $SubTitle = 'Add Level 1';
        return view(
            'Admin._categories.create_level_1',
            compact('MainTitle', 'SubTitle')
        );
    }

    public function storeLevel1(
        StoreCategoryRequest $request,
        StoreLevel1CategoryAction $store_level_1_category_action
    ) {
        DB::beginTransaction();
        try {
            $store_level_1_category_action->execute($request);
            DB::commit();
            session()->flash('_added', 'Category has been created successfully');
            return redirect()->route('categories.index');
        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('error', 'Cannot add!' . $exception->getMessage());
            return redirect()->route('categories.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $MainTitle = 'Categories';
        $SubTitle = 'View';
        $category = Category::find($id);
        $level1 = Category::with('childs')->where('level', 'level1')->get();
        return view('Admin._categories.edit', compact('MainTitle', 'SubTitle', 'category', 'level1'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        if ($request->file('image')) {
            if ($category->image) {
                //Remove old file
                UploadFile::RemoveFile($category->image);
            }

            $img = UploadFile::UploadSinglelFile($request->file('image'), 'categories');
        } else {
            $img = $category->image;
        }

        $level = 'level1';
        if ($request->parent) {
            $parent = Category::find($request->parent);
            if ($parent->parent) {
                $level = 'level3';
            } else {
                $level = 'level2';
            }
        }
        $input = $request->all();
        DB::beginTransaction();
        try {
            $category->level = $level;
            $category->image = $img;
            $category->parent = $input['parent'];
            $category->translate('en')->name = $input['name_en'];
            $category->translate('ar')->name = $input['name_ar'];
            $category->translate('en')->title = $input['title_en'];
            $category->translate('ar')->title = $input['title_ar'];
            $category->translate('en')->alt = $input['alt_en'];
            $category->translate('ar')->alt = $input['alt_ar'];
            $category->translate('en')->description = $input['descri_en'];
            $category->translate('ar')->description = $input['descri_ar'];
            $category->translate('en')->description_meta = $input['descri_meta_en'];
            $category->translate('ar')->description_meta = $input['descri_meta_ar'];
            $category->translate('en')->keywords_meta = $input['keywords_meta_en'];
            $category->translate('ar')->keywords_meta = $input['keywords_meta_ar'];
            $category->translate('en')->keywords = $input['keywords_en'];
            $category->translate('ar')->keywords = $input['keywords_ar'];
            $category->save();
            DB::commit();
            session()->flash('_updated', 'Category data has been updated succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    // destroyLevel1
    /**
     * Remove the specified resource from storage.
     */
    public function destroyLevel1(
        //DestroyLevel1Request $request,
        $id,
        DestroyLevel1Action $destroy_level_1_action
    ) {
        try {
            $category = Category::findOrFail($id)
                ->where('level', 'level1');
        } catch (ModelNotFoundException $e) {
            return response()->json([], 101);
        }

        DB::beginTransaction();

        try {
            $destroy_level_1_action->execute($id);
            DB::commit();
            return response()->json(['id' => $id], 200);
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception->getTraceAsString();
            return response();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if (count($category->childs)) {
            return response()->json(['error' => "cant't delete this category,it has children's"], 401);
        } else {
            if ($category->image) {
                UploadFile::RemoveFile($category->image);
            }

            foreach ($category->products as $product) {
                $product->category_id = null;
                $product->save();
            }
            $category->delete();
            return response()->json(['id' => $id, 'success' => 'Data is successfully deleted']);
        }
    }
    /**
     * Mak Level one category featured in home page
     */
    public function makeFeatured($id)
    {
        $category = Category::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($category->featured) {
                $category->featured = 0;
                $category->save();
                DB::commit();
                return response()->json(['id' => $id, 'featured' => $category->featured, 'success' => 'Category has been removed from featured.']);
            } else {
                $category->featured = 1;
                $category->save();
                DB::commit();
                return response()->json(['id' => $id, 'featured' => $category->featured, 'success' => 'Category has been added as featured.']);
            }
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }


    /**
     * Mak category showing in shop by category section in home page
     */
    public function showCategory($id)
    {
        $category = Category::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($category->show) {
                $category->show = 0;
                $category->save();
                DB::commit();
                return response()->json(['id' => $id, 'show' => $category->show, 'success' => 'Category has been hidden successfully.']);
            } else {
                $category->show = 1;
                $category->save();
                DB::commit();
                return response()->json(['id' => $id, 'show' => $category->show, 'success' => 'Category has been shown successfully.']);
            }
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollback();
            abort(500);
        }
    }

    public function allLevel3()
    {
        $MainTitle = 'Categories';
        $SubTitle = 'Level Three';
        $categories = Category::with(['translations' => function ($query) {
            $query->select(['locale', 'name', 'category_id']);
        }, 'shopProducts'])
            ->where('level', 'level3')->select(['id', 'image', 'featured'])->get()->sortByDesc(function ($category) {
                return $category->shopProducts->count();
            });
        return view('Admin._categories.all_level3s', compact('categories', 'MainTitle', 'SubTitle'));
    }

    function topBrandsindex($category_id)
    {

        $categoryLeveltwo = (DB::table('categories')->where('parent', '=', $category_id)
            ->pluck('id')->toArray());

        $categoryLevelThree = (DB::table('categories')->whereIn('parent', $categoryLeveltwo)
            ->pluck('id')->toArray());

        $brandIds = DB::table('brand_categories')->whereIn('category_id', $categoryLevelThree)
            ->pluck('brand_id')->toArray();

        $brands = BrandTranslation::whereIn('brand_id', $brandIds)->where('locale', 'en')->get();

        //dd($brandsData);

        return view('Admin._categories.topBrands', compact('brands', 'category_id'));
    }

    function topBrandsCreate($category_id)
    {
        $categoryLeveltwo = (DB::table('categories')->where('parent', '=', $category_id)
            ->pluck('id')->toArray());

        $categoryLevelThree = (DB::table('categories')->whereIn('parent', $categoryLeveltwo)
            ->pluck('id')->toArray());

        $brandIds = DB::table('brand_categories')->whereIn('category_id', $categoryLevelThree)
            ->pluck('brand_id')->toArray();

        $brands = Brand::whereIn('id', $brandIds)->get();

        $oldBrands = CategoryHomeBrand::where('category_id', $category_id)->orderby('order')->get();

        if ($oldBrands->count() > 0) {
            return view('Admin._categories.topBrands', compact('brands', 'category_id', 'oldBrands'));
        } else {
            return view('Admin._categories.topBrands', compact('brands', 'category_id'));
        }
    }

    function topBrandStore(Request $request)
    {
        $brands = $request->all();
        //dd($brands);
        CategoryHomeBrand::create(
            [
                'category_id' => $request->category_id,
                'brand_id'    => $request->brand_one,
                'order'       => '1',
            ]
        );
        CategoryHomeBrand::create(
            [
                'category_id' => $request->category_id,
                'brand_id'    => $request->brand_two,
                'order'       => '2',
            ]
        );
        CategoryHomeBrand::create(
            [
                'category_id' => $request->category_id,
                'brand_id'    => $request->brand_three,
                'order'       => '3',
            ]
        );
        CategoryHomeBrand::create(
            [
                'category_id' => $request->category_id,
                'brand_id'    => $request->brand_four,
                'order'       => '4',
            ]
        );
        session()->flash('_added', 'Category Top Brands Have been created successfully');
        return redirect()->back();
    }

    function topBrandUpdate(Request $request)
    {
        //$brands = $request->all();
        //dd($brands);
        $brands = CategoryHomeBrand::where('category_id', $request->category_id)->orderby('order')->get();
        //dd($brands);
        foreach ($brands as $key => $value) {
            $newkey = $key + 1;
            $value->where('order', $newkey)->where('category_id', $request->category_id)->update([
                'brand_id'    => $request->input('brand_' . $newkey)
            ]);
        }
        session()->flash('_added', 'Category Top Brands Have been updated successfully');
        return redirect()->back();
    }

    function topCategoriesCreate($category_id)
    {

        $categoryLeveltwo = (DB::table('categories')->where('parent', '=', $category_id)
            ->pluck('id')->toArray());

        $categoryLevelThree = (DB::table('categories')->whereIn('parent', $categoryLeveltwo)
            ->pluck('id')->toArray());

        $allChildCategoriesIds = array_merge($categoryLeveltwo, $categoryLevelThree);

        $categories = Category::whereIn('id', $allChildCategoriesIds)->get();

        $oldCategories = CategoryHomeCategory::where('parent_category_id', $category_id)->orderby('order')->get();

        if ($oldCategories->count() > 0) {
            return view('Admin._categories.topCategories', compact('categories', 'category_id', 'oldCategories'));
        } else {
            return view('Admin._categories.topCategories', compact('categories', 'category_id'));
        }
    }

    function topCategoriestore(Request $request)
    {
        $brands = $request->all();
        //dd($brands);
        CategoryHomeCategory::create(
            [
                'parent_category_id' => $request->category_id,
                'child_category_id'  => $request->category_one,
                'order'              => '1',
            ]
        );
        CategoryHomeCategory::create(
            [
                'parent_category_id' => $request->category_id,
                'child_category_id'  => $request->category_two,
                'order'              => '2',
            ]
        );
        CategoryHomeCategory::create(
            [
                'parent_category_id' => $request->category_id,
                'child_category_id'  => $request->category_three,
                'order'              => '3',
            ]
        );
        CategoryHomeCategory::create(
            [
                'parent_category_id' => $request->category_id,
                'child_category_id'  => $request->category_four,
                'order'              => '4',
            ]
        );

        return redirect()->back()->with(['success' => 'brand added successfully to home screen']);
    }

    function topCategoriesUpdate(Request $request)
    {
        //$brands = $request->all();
        //dd($brands);
        $categories = CategoryHomeCategory::where('parent_category_id', $request->category_id)->orderby('order')->get();
        //dd($brands);
        foreach ($categories as $key => $value) {
            $newkey = $key + 1;
            $value->where('order', $newkey)->where('parent_category_id', $request->category_id)->update([
                'child_category_id'    => $request->input('category_' . $newkey)
            ]);
        }
        session()->flash('_added', 'Category Top Categories Have been updated successfully');
        return redirect()->back();
    }
}
