<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteSelectedShopProductsRequest;
use App\Http\Requests\Admin\StoreShopProductRequest;
use App\Http\Requests\Admin\UpdatePricesExcel;
use App\Http\Requests\Admin\UpdateShopProductRequest;
use App\Http\Requests\Admin\StoreBennerRequest;
use App\Imports\UpdatePricesExcelImport;
use App\Imports\UpdateQuantitiesExcelImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\QuantityType;
use App\Models\Bundel;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Bundels';
        $SubTitle = 'View';
        $shop_count = Bundel::count();
        return view('Admin._bundels.index', compact('MainTitle', 'SubTitle', 'shop_count'));
    }

    /**
     * Display a listing of the resource in DT.
     */
    public function products()
    {
        ini_set('memory_limit', '1024M'); // or you could use 1G
        $records = Bundel::all();
        return Datatables::of($records)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Bundels';
        $SubTitle = 'Add';
        $level3Categories = Category::where('level', 'level3')->get();
        $categories = Category::where('level' ,'level1')->get();
        $brands = Brand::all();
        $quantityTypes = QuantityType::all();
        return view('Admin._bundels.create', compact('MainTitle', 'SubTitle', 'level3Categories', 'brands', 'quantityTypes' , 'categories'));
    }

    /**
     * Show the form for upload CSV file.
     */
    public function import()
    {
        $MainTitle = 'Bundel';
        $SubTitle = 'Import Bundel from CSV ';
        return view('Admin._bundels.import', compact('MainTitle', 'SubTitle'));
    }

     /**
     * Show the form for upload CSV file.
     */
    public function updateProductDetails()
    {
        $MainTitle = 'Shop Products';
        $SubTitle = 'Import Shop Products from CSV ';
        return view('Admin._shop_products.update_details', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Show the form for upload CSV file.
     */
    public function updatePrices()
    {
        $MainTitle = 'Shop Products';
        $SubTitle = 'Import Shop Products Prices';
        return view('Admin._shop_products.update_prices', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Update a keywords of products.
     *
     * @param UpdatePricesExcel $request
     * @return RedirectResponse
     */
    public function updatePricesExcel(UpdatePricesExcel $request)
    {
        set_time_limit(0);
        DB::beginTransaction();
        try {
            Excel::import(new UpdatePricesExcelImport(), $request->file('file'));
            DB::commit();
            return redirect()->route('shop.products.index')->with('_added', 'Products Prices have been successfully updated.');
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurred, Please try again later!.');
        }
    }

    /**
     * Show the form for upload CSV file.
     */
    public function updateQuantities()
    {
        $MainTitle = 'Shop Products';
        $SubTitle = 'Import Shop Products Quantities';
        return view('Admin._shop_products.update_quantities', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Update a keywords of products.
     *
     * @param UpdatePricesExcel $request
     * @return RedirectResponse
     */
    public function updateQuantitiesExcel(UpdatePricesExcel $request)
    {
        set_time_limit(0);
        DB::beginTransaction();
        try {
            Excel::import(new UpdateQuantitiesExcelImport(), $request->file('file'));
            DB::commit();
            return redirect()->route('shop.products.index')->with('_added', 'Products Keywords have been successfully updated.');
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurred, Please try again later!.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
             if ($request->file('image_en')) {
                $imageEn = UploadFile::UploadSinglelFile($request->file('image_en'), 'bundels');
            }
            
            if ($request->file('image_ar')) {
                $imageAr = UploadFile::UploadSinglelFile($request->file('image_ar'), 'bundels');
            }
            
            if ($request->file('mobile_image_en')) {
                $mobileImageEn = UploadFile::UploadSinglelFile($request->file('mobile_image_en'), 'bundels');
            }
            
            if ($request->file('mobile_image_ar')) {
                $mobileImageAr = UploadFile::UploadSinglelFile($request->file('mobile_image_ar'), 'bundels');
            }
            
            $bundel = Bundel::create([
                'qty' => $request->input('qty'),
                'discount_percentage' => $request->input('discount_percentage'),
                'sku_code' => $request->input('sku_code'),


                'en' => [
                    'name' => $request->input('name_en'),
                    'description' => $request->input('description_en'),
                    'title' => $request->input('title_en'),
                    'alt' => $request->input('alt_en'),
                    'description_meta' => $request->input('description_meta_en'),
                    'keywords' => $request->input('keywords_en'),
                    'keywords_meta' => $request->input('keywords_meta_en'),
                    'seller' => $request->input('seller_en'),
                    'sla' => $request->input('sla_en'),
                    'note' => $request->input('note_en'),
                    'image' => $request->file('image_en') ? UploadFile::UploadSinglelFile($request->file('image_en'), 'bundels') : null,
                    'mobile_image' => $request->file('mobile_image_en') ? UploadFile::UploadSinglelFile($request->file('mobile_image_en'), 'bundels') : null,
                ],
                'ar' => [
                    'name' => $request->input('name_ar'),
                    'description' => $request->input('description_ar'),
                    'title' => $request->input('title_ar'),
                    'alt' => $request->input('alt_ar'),
                    'description_meta' => $request->input('description_meta_ar'),
                    'keywords' => $request->input('keywords_ar'),
                    'keywords_meta' => $request->input('keywords_meta_ar'),
                    'seller' => $request->input('seller_ar'),
                    'sla' => $request->input('sla_ar'),
                    'note' => $request->input('note_ar'),
                    'image' => $request->file('image_ar') ? UploadFile::UploadSinglelFile($request->file('image_ar'), 'bundels') : null,
                    'mobile_image' => $request->file('mobile_image_ar') ? UploadFile::UploadSinglelFile($request->file('mobile_image_ar'), 'bundels') : null,
                ],
            ]);
            
            $bundel->categories()->sync($request['category_id']);

            DB::commit();
            session()->flash('_added', 'Shop Product data has been created succssfuly');
            return redirect()->route('bundels.index');
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $MainTitle = 'Bundels';
        $SubTitle = 'Edit';
        $bundel = Bundel::findOrFail($id);
        $categories = Category::where('level' ,'level1')->get();
        return view('Admin._bundels.edit', compact('MainTitle', 'SubTitle' , 'categories' , 'bundel'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {   
        $bundel = Bundel::findOrFail($id);
        DB::beginTransaction();
        try {
            //upload  new image file
            if ($request->file('image_en')) {
                //Remove old file
                UploadFile::RemoveFile($bundel->translate('en')->image);
                $bundel->translate('en')->image = UploadFile::UploadSinglelFile($request->file('image_en'), 'bundels');
            }
            
            if ($request->file('image_ar')) {
                //Remove old file
                UploadFile::RemoveFile($bundel->translate('ar')->image);
                $bundel->translate('ar')->image = UploadFile::UploadSinglelFile($request->file('image_ar'), 'bundels');
            }
            
            if ($request->file('mobile_image_en')) {
                //Remove old file
                UploadFile::RemoveFile($bundel->translate('en')->mobile_image);
                $bundel->translate('en')->mobile_image = UploadFile::UploadSinglelFile($request->file('mobile_image_en'), 'bundels');
            }
            
            if ($request->file('mobile_image_ar')) {
                //Remove old file
                UploadFile::RemoveFile($bundel->translate('ar')->mobile_image);
                $bundel->translate('ar')->mobile_image = UploadFile::UploadSinglelFile($request->file('mobile_image_ar'), 'bundels');
            }
            

            $bundel->qty = $request->input('qty');
            $bundel->sku_code = $request->input('sku_code');
            $bundel->discount_percentage = $request->input('discount_percentage');
            $bundel->translate('en')->name = $request->input('name_en');
            $bundel->translate('ar')->name = $request->input('name_ar');
            $bundel->translate('en')->alt = $request->input('alt_en');
            $bundel->translate('ar')->alt = $request->input('alt_ar');
            $bundel->translate('en')->title = $request->input('title_en');
            $bundel->translate('ar')->title = $request->input('title_ar');
            $bundel->translate('en')->description = $request->input('description_en');
            $bundel->translate('ar')->description = $request->input('description_ar');
            $bundel->translate('en')->description_meta = $request->input('description_meta_en');
            $bundel->translate('ar')->description_meta = $request->input('description_meta_ar');
            $bundel->translate('en')->keywords_meta = $request->input('keywords_meta_en');
            $bundel->translate('ar')->keywords_meta = $request->input('keywords_meta_ar');
            $bundel->translate('en')->keywords = $request->input('keywords_en');
            $bundel->translate('ar')->keywords = $request->input('keywords_ar');
            $bundel->translate('en')->seller = $request->input('seller_en');
            $bundel->translate('ar')->seller = $request->input('seller_ar');
            $bundel->translate('en')->sla = $request->input('sla_en');
            $bundel->translate('ar')->sla = $request->input('sla_ar');
            $bundel->translate('en')->note = $request->input('note_en');
            $bundel->translate('ar')->note = $request->input('note_ar');
            $bundel->categories()->sync($request['category_id']);
            $bundel->save();
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
            $product = ShopProduct::findOrFail($id);
            //Remove old multiple file
            if (count($product->images)) {
                UploadFile::RemoveMultiFiles('App\Models\ShopProduct', $id);
            }

            //Remove old single file
            if ($product->image) {
                UploadFile::RemoveFile($product->image);
            }

            //Remove old file
            if (isset($product->pdf)) {
                UploadFile::RemoveFile($product->pdf);
            }

            $product->delete();
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
            $products = ShopProduct::all();

            foreach ($products as $product) {
                //Remove old multiple file
                if (count($product->images)) {
                    UploadFile::RemoveMultiFiles('App\Models\ShopProduct', $product->id);
                }

                //Remove old single file
                if ($product->image) {
                    UploadFile::RemoveFile($product->image);
                }

                //Remove old file
                if (isset($product->pdf)) {
                    UploadFile::RemoveFile($product->pdf);
                }

                $product->delete();
            }
            DB::commit();
            session()->flash('_added', 'Products data has been deleted successfully');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            return response();
        }
    }


    //get assigned products data from DB, then return data in html table
    public function getBundels(Request $request)
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
        $bundels = Bundel::when($request->input('column'), function ($query) use ($request) {
            if ($request->input('column') == 'name') {
                return $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('value') . '%');
                });
            }

        })->with(['categories' => function ($query) use ($request) {
            $query->select(['categories.id']);
        }
        ])
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
        foreach ($bundels as $bundel) {
            $result .= '<tr id="tr-' . $bundel->id . '">';
            $result .= '<td>';
            $result .= '<input form="deleteForm" type="checkbox" name="products[]" value="' . $bundel->id . '">';
            $result .= '</td>';
            $result .= '<td>' . $bundel->id . '</td>';
            $result .= '<td>';
            $result .= '<img src="' . asset('storage/' . $bundel->image) . '" width="80">';
            $result .= '</td>';
            $result .= '<td>';
            $result .= $bundel->name;
            $result .= '</td>';
            $result .= '<td>';
            $result .= ($bundel->show ? ' <a style="color:#fff" class="btn-sm btn btn-primary toggleShow" id="shop-product-' . $bundel->id . '" title="Hide this product from website" data-content="' . $bundel->id . '"><i id="i-shop-product-' . $bundel->id . '" class="fa fa-eye"></i></a>' : ' <a style="color:#fff" class="btn-sm btn btn-primary toggleShow" id="shop-product-' . $bundel->id . '" title="Show this product in website" data-content="' . $bundel->id . '"><i id="i-shop-product-' . $bundel->id . '" class="fa fa-eye-slash"></i></a>' ) . ' ';
            $result .= '<a title="edit product" class="btn-sm btn btn-primary" href="' . route('bundels.edit', $bundel->id) . '"><i class="fa fa-edit"></i></a> ';
            $result .= '<a style="color:#fff" class="btn-sm btn btn-danger delete" data-content="' . $bundel->id . '" title="delete product"><i class="fa fa-trash"></i></a> ';
            
            // Add the new button to redirect to bundel_shop_products
            $result .= '<a title="View Bundel Shop Products" class="btn-sm btn btn-success" href="' . route('bundels.shop.products', $bundel->id) . '">View Bundel Shop Products</a>';
            
            $result .= '</td>';
            $result .= '</tr>';
        }

        return response()->json(['result' => $result, 'links' => $bundels->links()->render()], 200);
    }
    
    public function shopProducts($bundelId)
    {
        try {
            // Get the default locale, or you can set a specific locale
            $locale = app()->getLocale(); // Or set 'en', 'ar', etc.
    
            // Get all products related to the given bundle ID along with translations, paginated
            $products = DB::table('bundel_shop_product')
                ->join('shop_products', 'bundel_shop_product.shop_product_id', '=', 'shop_products.id')
                ->leftJoin('shop_product_translations', function ($join) use ($locale) {
                    $join->on('shop_products.id', '=', 'shop_product_translations.shop_product_id')
                         ->where('shop_product_translations.locale', '=', $locale);
                })
                ->where('bundel_shop_product.bundel_id', $bundelId)
                ->select(
                    'shop_products.*', 
                    'bundel_shop_product.qty', 
                    'bundel_shop_product.id as bundel_shop_product_id', // Include bundel_shop_product.id
                    'shop_product_translations.name as name', 
                    'shop_product_translations.description as description' // Include translated fields
                )
                ->paginate(5); // Paginate, 8 products per page
    
            // if ($products->isEmpty()) {
            //     // return redirect()->back()->with('error', 'No products found for this bundle!');
            // }
            $MainTitle = "Bundel # " . $bundelId . " products";
            $SubTitle = "Bundel # " . $bundelId . " shop_products";
    
            // Return to the view with the paginated products data using compact
            return view('Admin._bundels.shop_products', compact('products' , 'MainTitle' , 'SubTitle' , 'bundelId'));
    
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'An error occurred while fetching the products!');
        }
    }
    
        /**
     * Toggle show products in website
     */
    public function toggleShow($id)
    {
        $bundel = Bundel::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($bundel->show) {
                $bundel->show = 0;
                $bundel->save();
                DB::commit();
                return response()->json(['id' => $id, 'show' => $bundel->show, 'success' => 'Shop product has been hidden from website.']);
            } else {
                $bundel->show = 1;
                $bundel->save();
                DB::commit();
                return response()->json(['id' => $id, 'show' => $bundel->show, 'success' => 'Shop product has been shown in website.']);
            }
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    
    public function bundelBannerIndex()
    {
        $MainTitle = 'Bundel Banners';
        $SubTitle  = 'View';
        return view('Admin._bundels.banner_index', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function banners()
    {
        $records = Banner::where('section' , 10)->get();
        return Datatables::of($records)->make(true);
    }
    
    public function createBanner()
    {
        $MainTitle = 'Bundel Banner Create';
        $SubTitle  = 'Add';
        return view('Admin._bundels.createBanner', compact('MainTitle', 'SubTitle'));
    }
    
    public function storeBanner(StoreBennerRequest $request)
    {
        $input = $request->all();

        //upload new file
        if ($request->file('imgAr'))
            $imgAr =  UploadFile::UploadSinglelFile($request->file('imgAr'), 'banners');
        else
            $imgAr = null;

        if ($request->file('imgEn'))
            $imgEn =  UploadFile::UploadSinglelFile($request->file('imgEn'), 'banners');
        else
            $imgEn = null;

        //upload new file
        if ($request->file('mobileimgAr'))
            $mob_imgAR =  UploadFile::UploadSinglelFile($request->file('mobileimgAr'), 'banners');
        else
            $mob_imgAR = null;

        if ($request->file('mobileimgEn'))
            $mob_imgEn =  UploadFile::UploadSinglelFile($request->file('mobileimgEn'), 'banners');
        else
            $mob_imgEn = null;
        DB::beginTransaction();
        try {
            Banner::create([
                'section' => $input['section'],
                'en' => [
                    'alt'       => $input['altEN'],
                    'img'       => $imgEn,
                    'mobileimg' => $mob_imgEn,
                    'url'       => $input['urlEn'],
                ],
                'ar' => [
                    'alt'       => $input['altAR'],
                    'img'       => $imgAr,
                    'mobileimg' => $mob_imgAR,
                    'url'       => $input['urlAr'],
                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Banner has been created succssfuly');
            return redirect()->route('bundel.banners.index');
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

}
