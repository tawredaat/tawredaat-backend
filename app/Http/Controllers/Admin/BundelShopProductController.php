<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteSelectedShopProductsRequest;
use App\Http\Requests\Admin\StoreShopProductRequest;
use App\Http\Requests\Admin\UpdatePricesExcel;
use App\Http\Requests\Admin\UpdateShopProductRequest;
use App\Imports\UpdatePricesExcelImport;
use App\Imports\UpdateQuantitiesExcelImport;
use App\Models\BundelShopProducts;
use App\Models\ShopProduct;
use App\Models\File;
use App\Models\QuantityType;
use App\Models\Bundel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class BundelShopProductController extends Controller
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
    public function create($bundel_id)
    {
        $MainTitle = 'Bundels';
        $SubTitle = 'Add';
        $level3Categories = Category::where('level', 'level3')->get();
        $categories = Category::get();
        $brands = Brand::all();
        $quantityTypes = QuantityType::all();
        return view('Admin._bundels.create', compact('MainTitle', 'SubTitle', 'level3Categories', 'brands', 'quantityTypes' , 'categories'));
    }

    /**
     * Show the form for upload CSV file.
     */
    public function import()
    {
        $MainTitle = 'Shop Products';
        $SubTitle = 'Import Shop Products from CSV ';
        return view('Admin._shop_products.import', compact('MainTitle', 'SubTitle'));
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
            $product = ShopProduct::where('sku_code', $request->productName)->first();
            if($product)
            {
                $existingProduct = BundelShopProducts::where('bundel_id', $request->bundelId)->where('shop_product_id' , $product->id)->first();
            }else{
                session()->flash('error', 'No product found with this sku_code please search first and confirm that product is exist');
                return redirect()->back();
            }
            
            if($request->qty <= 0)
            {
                session()->flash('error', 'You cannot add product with quantity zero');
                return redirect()->back();
            }
            
            if($existingProduct !== null) {
                // Set a flash message for the error
                session()->flash('error', 'This product already exists. You cannot add it again. You can update the quantity instead.');
                
                // Redirect back to the same page with the flash message
                return redirect()->back();
            }
            
            BundelShopProducts::create([
                'bundel_id' => $request->input('bundelId'),
                'shop_product_id' => $product->id,
                'qty' => $request->input('qty'),

            ]);
            DB::commit();
            session()->flash('_added', 'Shop Product data has been created succssfuly');
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $MainTitle = 'Shop Products';
        $SubTitle = 'Edit';
        $level3Categories = Category::where('level', 'level3')->get();
        $product = ShopProduct::findOrFail($id);
        $brands = Brand::all();
        $quantityTypes = QuantityType::all();
        return view('Admin._shop_products.edit', compact('MainTitle', 'SubTitle', 'product', 'level3Categories', 'brands', 'quantityTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateShopProductRequest $request, $id)
    {
        $product = ShopProduct::findOrFail($id);
        DB::beginTransaction();
        try {
            //upload  new image file
            if ($request->file('image')) {
                //Remove old file
                UploadFile::RemoveFile($product->image);
                $product->image = UploadFile::UploadSinglelFile($request->file('image'), 'shop_products');
            }
            //upload  new image file
            if ($request->file('mobileimg')) {
                if ($product->mobileimg) {
                    //Remove old file
                    UploadFile::RemoveFile($product->mobileimg);
                }
                $product->mobileimg = UploadFile::UploadSinglelFile($request->file('mobileimg'), 'shop_products');
            }
            //upload  new PDF file
            if ($request->file('pdf')) {
                if ($product->pdf) {
                    //Remove old file
                    UploadFile::RemoveFile($product->pdf);
                }
                $product->pdf = UploadFile::UploadSinglelFile($request->file('pdf'), 'shop_products');
            }
            $product->category_id = $request->input('category_id');
            $product->brand_id = $request->input('brand_id');
            $product->sku_code = $request->input('sku_code');
            $product->video = $request->input('video');
            $product->old_price = $request->input('old_price') ? $request->input('old_price') : 0;
            $product->new_price = $request->input('new_price');
            $product->soled_by_souqkahrba = $request->input('soled_by_souq') ? $request->input('soled_by_souq') : 0;
            $product->qty = $request->input('qty');
            $product->from = $request->input('from');
            $product->to = $request->input('to');
            $product->quantity_type_id = $request->input('qty_type');
            $product->translate('en')->name = $request->input('name_en');
            $product->translate('ar')->name = $request->input('name_ar');
            $product->translate('en')->slug = Str::slug($request->input('name_en'));
            $product->translate('ar')->slug = slugInArabic($request->input('name_ar'));
            $product->translate('en')->title = $request->input('title_en');
            $product->translate('ar')->title = $request->input('title_ar');
            $product->translate('en')->alt = $request->input('alt_en');
            $product->translate('ar')->alt = $request->input('alt_ar');
            $product->translate('en')->description = $request->input('description_en');
            $product->translate('ar')->description = $request->input('description_ar');
            $product->translate('en')->description_meta = $request->input('description_meta_en');
            $product->translate('ar')->description_meta = $request->input('description_meta_ar');
            $product->translate('en')->keywords_meta = $request->input('keywords_meta_en');
            $product->translate('ar')->keywords_meta = $request->input('keywords_meta_ar');
            $product->translate('en')->keywords = $request->input('keywords_en');
            $product->translate('ar')->keywords = $request->input('keywords_ar');
            $product->save();
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
            $bundelShopProduct = BundelShopProducts::find($id);
            if ($bundelShopProduct) {
                $bundelShopProduct->delete();
    
                // Commit the transaction after successful deletion
                DB::commit();
    
                // Flash success message
                session()->flash('_added', 'Product has been deleted successfully');
            } else {
                // Handle the case when the product is not found
                session()->flash('error', 'Product not found');
            }
    
            // Redirect back with the flash message
            return redirect()->back();
        } catch (\Exception $exception) {
            // Rollback in case of error
            DB::rollback();
    
            // You may want to log the exception or show an error message
            return redirect()->back()->with('error', 'An error occurred during deletion');
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

        })->with(['category' => function ($query) use ($request) {
            $query->select(['id']);
        },
            'brand' => function ($query) use ($request) {
                $query->select(['id']);
            }])
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
            $result .= '<a title="view images" class="btn-sm btn btn-primary" href="' . route('shop.products.images', $bundel->id) . '"><i class="far fa-images"></i></a> ';
            $result .= '<a title="edit product" class="btn-sm btn btn-primary" href="' . route('shop.products.edit', $bundel->id) . '"><i class="fa fa-edit"></i></a> ';
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
                ->paginate(7); // Paginate, 8 products per page
    
            if ($products->isEmpty()) {
                return redirect()->back()->with('error', 'No products found for this bundle!');
            }
            $MainTitle = "Bundel # " . $bundelId . " products";
            $SubTitle = "Bundel # " . $bundelId . " shop_products";
    
            // Return to the view with the paginated products data using compact
            return view('Admin._bundels.shop_products', compact('products' , 'MainTitle' , 'SubTitle'));
    
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'An error occurred while fetching the products!');
        }
    }
    
    public function updateQty(Request $request, $id)
    {
        try {
            $bundelShopProduct = BundelShopProducts::find($id);
            if ($bundelShopProduct) {
                $bundelShopProduct->qty = $request->qty;
                $bundelShopProduct->save();
                
                return response()->json(['success' => true]);
            }
    
            return response()->json(['success' => false, 'message' => 'Product not found']);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => 'An error occurred']);
        }
    }
    
    public function search(Request $request)
    {
        $name = $request->input('name');
        
        // Validate the input
        if (empty($name)) {
            return response()->json(['success' => false, 'message' => 'Product name is required.']);
        }

        // Search for products by name
       $product = ShopProduct::where('sku_code', $name)->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'default_qty' => $product->qty // Adjust this if needed
                ]
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }
    }
}
