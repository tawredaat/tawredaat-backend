<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDynamicPageRequest;
use App\Http\Requests\Admin\UpdateDynamicPageRequest;
use App\Models\File;
use App\Models\DynamicPage;
use App\Models\ShopProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class DynamicPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Dynamic Pages';
        $SubTitle = 'List';
        $shop_count = DynamicPage::count();
        return view('Admin._dynamic_pages.index', compact('MainTitle', 'SubTitle', 'shop_count'));
    }

    /**
     * Display a listing of the resource in DT.
     */
    public function dynamicPages()
    {
        ini_set('memory_limit', '1024M'); // or you could use 1G
        $records = DynamicPage::all();
        return Datatables::of($records)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Dynamic Pages';
        $SubTitle = 'Add';
        $shopProducts = ShopProduct::all();
        return view('Admin._dynamic_pages.create', compact('MainTitle', 'SubTitle' , 'shopProducts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDynamicPageRequest $request)
    {
        DB::beginTransaction();
        try {
            // Handle file uploads
            if ($request->file('main_banner_en')) {
                $imageEn = UploadFile::UploadSinglelFile($request->file('main_banner_en'), 'dynamic-pages');
            }
    
            if ($request->file('main_banner_ar')) {
                $imageAr = UploadFile::UploadSinglelFile($request->file('main_banner_ar'), 'dynamic-pages');
            }
    
            if ($request->file('main_banner_mobile_en')) {
                $mobileImageEn = UploadFile::UploadSinglelFile($request->file('main_banner_mobile_en'), 'dynamic-pages');
            }
    
            if ($request->file('main_banner_mobile_ar')) {
                $mobileImageAr = UploadFile::UploadSinglelFile($request->file('main_banner_mobile_ar'), 'dynamic-pages');
            }
            $nameEn =  $request->input('name_en');
            $slug = Str::slug($nameEn);
            $url = 'https://www.tawredaat.com/pages/' . $slug;

            // Create the dynamic page
            $dynamicPage = DynamicPage::create([
                'url' => $url,
                'en' => [
                    'name' => $request->input('name_en'),
                    'description' => $request->input('description_en'),
                    'page_title' => $request->input('page_title_en'),
                    'alt' => $request->input('alt_en'),
                    'main_banner' => $request->file('main_banner_en') ? $imageEn : null,
                    'main_banner_mobile' => $request->file('mobile_image_en') ? $mobileImageEn : null,
                ],
                'ar' => [
                    'name' => $request->input('name_ar'),
                    'description' => $request->input('description_ar'),
                    'page_title' => $request->input('page_title_ar'),
                    'alt' => $request->input('alt_ar'),
                    'main_banner' => $request->file('image_ar') ? $imageAr : null,
                    'main_banner_mobile' => $request->file('mobile_image_ar') ? $mobileImageAr : null,
                ],
            ]);
    
            // Check if 'shopProducts' is in the request
            if ($request->has('shopProducts')) {
                $productIds = $request->input('shopProducts'); // Array of product IDs
                
                // Map the product IDs to the format needed for the pivot table
                $productData = array_map(function ($productId) use ($dynamicPage) {
                    return [
                        'shop_product_id' => $productId,
                        'dynamic_page_id' => $dynamicPage->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $productIds);
                // Insert the data into the pivot table (assuming you have a pivot table for this relation)
                DB::table('dynamic_pages_shop_products')->insert($productData);
            }
    
            DB::commit();
            session()->flash('_added', 'Dynamic Page has been created successfully');
            return redirect()->route('dynamic-page.index');
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollback();
            session()->flash('_error', 'There was an error creating the dynamic page');
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $MainTitle = 'Dynamic Pages';
        $SubTitle = 'Edit';
        $shopProducts = ShopProduct::all();
        $dynamic_page = DynamicPage::findOrFail($id);
        return view('Admin._dynamic_pages.edit', compact('MainTitle', 'SubTitle' , 'dynamic_page' , 'shopProducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateDynamicPageRequest $request, $id)
    {   
        $page = DynamicPage::findOrFail($id);
        DB::beginTransaction();
        try {
            //upload  new image file
            
            if ($request->file('main_banner_en')) {
                UploadFile::RemoveFile($page->translate('en')->main_banner);
                $page->translate('en')->main_banner = UploadFile::UploadSinglelFile($request->file('main_banner_en'), 'dynamic-pages');
            }
    
            if ($request->file('main_banner_ar')) {
                UploadFile::RemoveFile($page->translate('ar')->main_banner);
                $page->translate('ar')->main_banner = UploadFile::UploadSinglelFile($request->file('main_banner_ar'), 'dynamic-pages');
            }
    
            if ($request->file('main_banner_mobile_en')) {
                UploadFile::RemoveFile($page->translate('en')->main_banner_mobile);
                $page->translate('en')->main_banner_mobile = UploadFile::UploadSinglelFile($request->file('main_banner_mobile_en'), 'dynamic-pages');
            }
    
            if ($request->file('main_banner_mobile_ar')) {
                UploadFile::RemoveFile($page->translate('ar')->main_banner_mobile);
                $page->translate('ar')->main_banner_mobile = UploadFile::UploadSinglelFile($request->file('main_banner_mobile_ar'), 'dynamic-pages');
            }
            $nameEn =  $request->input('name_en');
            $slug = Str::slug($nameEn);
            $url = 'https://www.tawredaat.com/pages/' . $slug;
            
            $page->url = $url;
            $page->translate('en')->name = $request->input('name_en');
            $page->translate('ar')->name = $request->input('name_ar');
            $page->translate('en')->alt = $request->input('alt_en');
            $page->translate('ar')->alt = $request->input('alt_ar');
            $page->translate('en')->page_title = $request->input('page_title_en');
            $page->translate('ar')->page_title = $request->input('page_title_ar');
            $page->translate('en')->description = $request->input('description_en');
            $page->translate('ar')->description = $request->input('description_ar');
            if ($request->has('shopProducts')) {
                $currentProductIds = $page->shopProducts->pluck('id')->toArray();
                $newProductIds = $request->input('shopProducts');
                
                if (!empty($newProductIds)) {
                    DB::table('dynamic_pages_shop_products')
                        ->where('dynamic_page_id', $page->id)
                        ->delete();
                }
                
                // Add new products that aren't already associated
                $productsToAdd = array_diff($newProductIds, $currentProductIds);

                $insertData = [];
                foreach ($newProductIds as $productId) {
                    $insertData[] = [
                        'dynamic_page_id' => $page->id,
                        'shop_product_id' => $productId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                // Perform the bulk insert into the pivot table
                DB::table('dynamic_pages_shop_products')->insert($insertData);
            }
            $page->save();
            DB::commit();
            session()->flash('_added', 'Product data has been updated succssfuly');
            return back();
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $page = DynamicPage::findOrFail($id);
            //Remove old multiple file
            if (count($page->images)) {
                UploadFile::RemoveMultiFiles('App\Models\ShopProduct', $id);
            }

            //Remove old single file
            if ($page->translate('en')->main_banner){
                UploadFile::RemoveFile($page->translate('en')->main_banner);
            }
            
            if ($page->translate('ar')->main_banner){
                UploadFile::RemoveFile($page->translate('ar')->main_banner);
            }
            
            //Remove old single file
            if ($page->translate('en')->main_banner_mobile){
                UploadFile::RemoveFile($page->translate('en')->main_banner_mobile);
            }
            
            if ($page->translate('ar')->main_banner_mobile){
                UploadFile::RemoveFile($page->translate('ar')->main_banner);
            }

            //Remove old file
            if (isset($page->pdf)) {
                UploadFile::RemoveFile($page->pdf);
            }

            $page->delete();
            DB::commit();
            return response()->json(['id' => $id], 200);
        } catch (\Exception $exception) {
            DB::rollback();
            return response();
        }
    }


    public function deleteAll()
    {
        DB::beginTransaction();
        try {
            $pages = DynamicPage::all();

            foreach ($pages as $page) {
                //Remove old multiple file
                if (count($page->images)) {
                    UploadFile::RemoveMultiFiles('App\Models\ShopProduct', $product->id);
                }

                //Remove old single file
                if ($page->image) {
                    UploadFile::RemoveFile($page->image);
                }

                //Remove old file
                if (isset($product->pdf)) {
                    UploadFile::RemoveFile($page->pdf);
                }

                $product->delete();
            }
            DB::commit();
            session()->flash('_added', 'Page data has been deleted successfully');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            return response();
        }
    }


    //get assigned products data from DB, then return data in html table
    public function getDynamicPages(Request $request)
    {
        ini_set('memory_limit', '1024M'); // or you could use 1G
        //return $request->all();
        $pagination = 0;
        if ($request->input('pagination') == 'true') {
            $pagination = 500;
        } else {
            $pagination = 10;
        }

        //return $pagination;
        $dynamicPages = DynamicPage::when($request->input('column'), function ($query) use ($request) {
            if ($request->input('column') == 'name') {
                return $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('value') . '%');
                });
            }

        })
            ->select(['id','created_at','show'])
            ->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
                $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
            })->when($request->input('column') == 'id', function ($query) use ($request) {
            return $query->where('id', 'like', '%' . $request->input('value') . '%');
        })
            ->when($request->input('l3'), function ($query) use ($request) {
                return $query->where('category_id', $request->input('l3'));
            })
            ->orderBy('id', 'DESC')
            ->paginate($pagination)->appends([
            'column' => $request->input('column'),
            'value' => $request->input('value'),
            'image' => $request->input('image'),
        ]);
        $result = '';
        foreach ($dynamicPages as $page) {
            $result .= '<tr id="tr-' . $page->id . '">';
            $result .= '<td>';
            $result .= '<input form="deleteForm" type="checkbox" name="products[]" value="' . $page->id . '">';
            $result .= '</td>';
            $result .= '<td>' . $page->id . '</td>';
            $result .= '<td>';
            $result .= '<img src="' . asset('storage/' . $page->translate('en')->main_banner) . '" width="80">';
            $result .= '</td>';
            $result .= '<td>';
            $result .= $page->name;
            $result .= '</td>';
            $result .= '<td>';
            $result .= ($page->show ? ' <a style="color:#fff" class="btn-sm btn btn-primary toggleShow" id="shop-product-' . $page->id . '" title="Hide this product from website" data-content="' . $page->id . '"><i id="i-shop-product-' . $page->id . '" class="fa fa-eye"></i></a>' : ' <a style="color:#fff" class="btn-sm btn btn-primary toggleShow" id="shop-product-' . $page->id . '" title="Show this product in website" data-content="' . $page->id . '"><i id="i-shop-product-' . $page->id . '" class="fa fa-eye-slash"></i></a>' ) . ' ';
            $result .= '<a title="edit page" class="btn-sm btn btn-primary" href="' . route('dynamic-page.edit', $page->id) . '"><i class="fa fa-edit"></i></a> ';
            $result .= '<a style="color:#fff" class="btn-sm btn btn-danger delete" data-content="' . $page->id . '" title="delete Page"><i class="fa fa-trash"></i></a> ';
            
            $result .= '</td>';
            $result .= '</tr>';
        }

        return response()->json(['result' => $result, 'links' => $dynamicPages->links()->render()], 200);
    }
    
    
        /**
     * Toggle show products in website
     */
    public function toggleShow($id)
    {
        $page = DynamicPage::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($page->show) {
                $page->show = 0;
                $page->save();
                DB::commit();
                return response()->json(['id' => $id, 'show' => $page->show, 'success' => 'Page has been hidden from website.']);
            } else {
                $page->show = 1;
                $page->save();
                DB::commit();
                return response()->json(['id' => $id, 'show' => $page->show, 'success' => 'Page has been shown in website.']);
            }
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
}
