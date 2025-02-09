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
use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\QuantityType;
use App\Models\ShopProduct;
use App\Exports\ExportAllProducts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class ShopProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Shop Products';
        $SubTitle = 'View';
        $shop_count = ShopProduct::count();
        return view('Admin._shop_products.index', compact('MainTitle', 'SubTitle', 'shop_count'));
    }

    /**
     * Display a listing of the resource.
     */
    public function specifications($id)
    {
        $MainTitle = 'Shop Products';
        $SubTitle = 'Specifications';
        $product = ShopProduct::findOrFail($id);
        return view('Admin._shop_products.specifications', compact('MainTitle', 'SubTitle', 'product'));
    }

    /**
     * Display a listing of the resource.
     */
    public function viewOffers()
    {
        $MainTitle = 'Shop Offers Products';
        $SubTitle = 'View';
        return view('Admin._shop_products.offers', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function products()
    {
        ini_set('memory_limit', '1024M'); // or you could use 1G
        $records = ShopProduct::all();
        return Datatables::of($records)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Shop Products';
        $SubTitle = 'Add';
        $level3Categories = Category::where('level', 'level3')->get();
        $brands = Brand::all();
        $quantityTypes = QuantityType::all();
        return view('Admin._shop_products.create', compact('MainTitle', 'SubTitle', 'level3Categories', 'brands', 'quantityTypes'));
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
    public function updateOffers()
    {
        $MainTitle = 'Shop Products';
        $SubTitle = 'Update Offers from CSV ';
        return view('Admin._shop_products.update_offers', compact('MainTitle', 'SubTitle'));
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
          dd($ex);
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurred, Please try again later!.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopProductRequest $request)
    {
        DB::beginTransaction();
        try {

            ShopProduct::create([
                'image' => $request->file('image') ? UploadFile::UploadSinglelFile($request->file('image'), 'products') : null,
                'mobileimg' => $request->file('mobileimg') ? UploadFile::UploadSinglelFile($request->file('mobileimg'), 'products') : null,
                'pdf' => $request->file('pdf') ? UploadFile::UploadSinglelFile($request->file('pdf'), 'products') : null,
                'category_id' => $request->input('category_id'),
                'brand_id' => $request->input('brand_id'),
                'sku_code' => $request->input('sku_code'),
                'video' => $request->input('video'),
                'old_price' => $request->input('old_price') ? $request->input('old_price') : 0,
                'new_price' => $request->input('new_price'),
                'soled_by_souqkahrba' => $request->input('soled_by_souq') ? $request->input('soled_by_souq') : 0,
                'qty' => $request->input('qty'),
                'quantity_type_id' => $request->input('qty_type'),
                'from' => $request->input('from'),
                'to' => $request->input('to'),

                'en' => [
                    'name' => $request->input('name_en'),
                    'slug' => Str::slug($request->input('name_en')),
                    'title' => $request->input('title_en'),
                    'alt' => $request->input('alt_en'),
                    'description' => $request->input('description_en'),
                    'description_meta' => $request->input('description_meta_en'),
                    'keywords_meta' => $request->input('keywords_meta_en'),
                    'keywords' => $request->input('keywords_en'),
                ],
                'ar' => [
                    'name' => $request->input('name_ar'),
                    'slug' => slugInArabic($request->input('name_ar')),
                    'title' => $request->input('title_ar'),
                    'alt' => $request->input('alt_ar'),
                    'description' => $request->input('description_ar'),
                    'description_meta' => $request->input('description_meta_ar'),
                    'keywords_meta' => $request->input('keywords_meta_ar'),
                    'keywords' => $request->input('keywords_ar'),

                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Shop Product data has been created succssfuly');
            return redirect()->route('shop.products.index');
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
          	if ($request->file('image_name1')) {
                if ($product->image_name1) {
                    //Remove old file
                    UploadFile::RemoveFile($product->image_name1);
                }
                $product->image_name1 = UploadFile::UploadSinglelFile($request->file('image_name1'), 'shop_products');
            }
          	if ($request->file('image_name2')) {
                if ($product->image_name2) {
                    //Remove old file
                    UploadFile::RemoveFile($product->image_name2);
                }
                $product->image_name1 = UploadFile::UploadSinglelFile($request->file('image_name1'), 'shop_products');
            }
          	if ($request->file('image_name3')) {
                if ($product->image_name3) {
                    //Remove old file
                    UploadFile::RemoveFile($product->image_name3);
                }
                $product->image_name3 = UploadFile::UploadSinglelFile($request->file('image_name3'), 'shop_products');
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

    public function deleteSelected(DeleteSelectedShopProductsRequest $request)
    {
        DB::beginTransaction();
        try {
            $products = ShopProduct::whereIn('id', $request->input('products', []))->get();

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

    public function hideSelected(Request $request)
    {
        DB::beginTransaction();
        try {
            $products = ShopProduct::whereIn('id', $request->id)->get();
            //dd($products);
            foreach ($products as $product) {
                $product->show=0;
                $product->save();
            }
            DB::commit();
            session()->flash('_added', 'Products data has been hidden successfully');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $exception->getMessage()]);
        }
    }
    public function showSelected(Request $request)
    {
        DB::beginTransaction();
        try {
            $products = ShopProduct::whereIn('id', $request->id)->get();
            //dd($products);
            foreach ($products as $product) {
                $product->show=1;
                $product->save();
            }
            DB::commit();
            session()->flash('_added', 'Products data has been shown successfully');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $exception->getMessage()]);
        }
    }
    /**
     * Toggle show products in website
     */
    public function toggleShow($id)
    {
        $product = ShopProduct::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($product->show) {
                $product->show = 0;
                $product->save();
                DB::commit();
                return response()->json(['id' => $id, 'show' => $product->show, 'success' => 'Shop product has been hidden from website.']);
            } else {
                $product->show = 1;
                $product->save();
                DB::commit();
                return response()->json(['id' => $id, 'show' => $product->show, 'success' => 'Shop product has been shown in website.']);
            }
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
   
    public function deleteFiltered(Request $request)
    {
        DB::beginTransaction();
        try {
            $products = ShopProduct::when($request->input('column'), function ($query) use ($request) {
                if ($request->input('column') == 'name') {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                }

                if ($request->input('column') == 'brand') {
                    return $query->whereHas('brand', function ($query) use ($request) {
                        return $query->whereHas('translations', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->input('value') . '%');
                        });
                    });
                }

                if ($request->input('column') == 'category') {
                    return $query->whereHas('category', function ($query) use ($request) {
                        return $query->whereHas('translations', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->input('value') . '%');
                        });
                    });
                }
            })->with(['category' => function ($query) use ($request) {
                $query->select(['id']);
            },
                'brand' => function ($query) use ($request) {
                    $query->select(['id']);
                }])
                ->select(['id', 'brand_id', 'category_id', 'image', 'pdf', 'created_at', 'featured'])
                ->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
                    $query->whereBetween('created_at', [Carbon::parse($request->start_date),
                        Carbon::parse($request->end_date)]);
                })->when($request->input('column') == 'id', function ($query) use ($request) {
                return $query->where('id', 'like', '%' . $request->input('value') . '%');
            })->when($request->input('l3'), function ($query) use ($request) {
                return $query->where('category_id', $request->input('l3'));
            })->get();

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
            return response()->json([], 204);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['error=', $exception->getMessage()], 500);
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

    public function deleteAllOffers()
    {
        DB::beginTransaction();
        try {
            $products = ShopProduct::whereNotNull('old_price')->get();

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

    /************************************************************
     * Module of Upload Multiple images to single product.
     */
    public function viewImages($id)
    {
        $product = ShopProduct::findOrFail($id);
        $MainTitle = 'Products';
        $SubTitle = "Upload images of ";
        return view('Admin._shop_products.images', compact('product', 'MainTitle', 'SubTitle'));
    }

    /**
     * return product images to be displayed in DT.
     */
    public function ProductsImages($id)
    {
        $records = File::where('model_id', $id)->where('model_type', 'App\Models\ShopProduct')->get();
        return Datatables::of($records)->make(true);
    }

    /**
     * store product images in File Table.
     */
    public function uploadImages(Request $request, $id)
    {
        $product = ShopProduct::findOrFail($id);
        DB::beginTransaction();
        try {
            //upload multiple files
            UploadFile::UploadMultiFiles($request->file('images'), 'shoPproductsImages', 'App\Models\ShopProduct', $product->id);

            DB::commit();
            return response()->json(['success' => 'done']);
            // return redirect()->route('subscriptions.index');
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([]);
        }
    }

    /**
     * delete a single image from product images .
     */
    public function deleteImage($id)
    {
        DB::beginTransaction();
        try {
            $image = File::findOrFail($id);
            //Remove old file
            if ($image->path) {
                UploadFile::RemoveFile($image->path);
            }
            $image->delete();
            DB::commit();
            return response()->json([], 200);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([]);
        }
    }

    public function deleteSelectedImage(Request $request)
    {

        // return  $request->images;
        if ($request->has('images')) {
            foreach ($request->images as $imageid) {
                $image = File::findOrFail($imageid);
                //Remove old file
                if ($image->path) {
                    UploadFile::RemoveFile($image->path);
                }

                $image->delete();
            }
            session()->flash('_added', 'Images  has been deleted successfully');
            return back();
        } else {
            session()->flash('error', 'Please Select an image');
            return back();
        }
    }

    //get assigned products data from DB, then return data in html table
    public function getProducts(Request $request)
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
        $products = ShopProduct::when($request->input('column'), function ($query) use ($request) {
            if ($request->input('column') == 'name') {
                return $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('value') . '%');
                });
            }

            if ($request->input('column') == 'brand') {
                return $query->whereHas('brand', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            }

            if ($request->input('column') == 'category') {
                return $query->whereHas('category', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            }

        })->with(['category' => function ($query) use ($request) {
            $query->select(['id']);
        },
            'brand' => function ($query) use ($request) {
                $query->select(['id']);
            }])
            ->select(['id', 'brand_id', 'category_id', 'image', 'created_at', 'featured','show'])
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
        foreach ($products as $product) {
            $result .= '<tr id="tr-' . $product->id . '">';
            $result .= '<td >';
            $result .= '<input form="deleteForm" type="checkbox" name="products[]" value="' . $product->id . '">';
            $result .= '</td >';
            $result .= '</td >';
            $result .= '<td>' . $product->id . '</td >';
            $result .= '<td >';
            $result .= '<img src="' . asset('storage/' . $product->image) . '" width="80">';
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->name;
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->brand ? $product->brand->name : '-';
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->category ? $product->category->name : '-';
            $result .= '</td >';
            $result .= '<td >';
            $result .= '<a class="btn-sm btn btn-primary"  href=' . route('shop.products.specifications', $product->id) . ' title="view specifications">' . count($product->specifications) . '</a> <a class="btn-sm btn btn-primary featured" id="shop-product-' . $product->id . '" ' . ($product->featured ? 'title ="Remove this product from featured in home page" style="color:red !important"' : 'title ="Make this product featured in home page"') . '  data-content="' . $product->id . '"><i class="fa fa-fire"></i></a>
            ' . ($product->show ? ' <a style="color:#fff" class="btn-sm btn btn-primary toggleShow" id="shop-product-' . $product->id . '" title ="Hide this product from website"  data-content="' . $product->id . '"><i id="i-shop-product-' . $product->id . '" class="fa fa-eye"></i></a>' : ' <a style="color:#fff" class="btn-sm btn btn-primary toggleShow" id="shop-product-' . $product->id . '" title ="Show this product in website"  data-content="' . $product->id . '"><i id="i-shop-product-' . $product->id . '" class="fa fa-eye-slash"></i></a>' ) . '  
            <a title="view images" class="btn-sm btn btn-primary"  href=' . route('shop.products.images', $product->id) . '><i class="far fa-images"></i></a> <a title="edit product" class="btn-sm btn btn-primary"  href=' . route('shop.products.edit', $product->id) . '><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn-sm btn btn-danger delete" data-content="' . $product->id . '" title="delete product"><i class="fa fa-trash"></i></a>';
            $result .= ' </td >';
            $result .= ' </tr >';
        }

        return response()->json(['result' => $result, 'links' => $products->links()->render()], 200);
    }

    public function removeFromOffer($id)
    {
        DB::beginTransaction();
        try {
            $product = ShopProduct::find($id);
            if ($product) {
                $product->old_price = null;
                $product->save();
                DB::commit();
                return response()->json(['id' => $id], 200);
            }
            return response()->json(['error' => 'Product not found!'], 200);
        } catch (\Exception $exception) {
            DB::rollback();
            return response();
        }
    }
    //get offers
    public function getOffers(Request $request)
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
        $products = ShopProduct::where('old_price', '>', 'new_price')->whereNotNull('new_price')->when($request->input('column'), function ($query) use ($request) {
            if ($request->input('column') == 'name') {
                return $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('value') . '%');
                });
            }

            if ($request->input('column') == 'brand') {
                return $query->whereHas('brand', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            }

            if ($request->input('column') == 'category') {
                return $query->whereHas('category', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            }

        })->with(['category' => function ($query) use ($request) {
            $query->select(['id']);
        },
            'brand' => function ($query) use ($request) {
                $query->select(['id']);
            }])
            ->select(['id', 'brand_id', 'category_id', 'image', 'old_price', 'new_price', 'created_at', 'featured'])
            ->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
                $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
            })->when($request->input('column') == 'id', function ($query) use ($request) {
            return $query->where('id', 'like', '%' . $request->input('value') . '%');
        })->orderBy('id', 'DESC')->paginate($pagination)->appends([
            'column' => $request->input('column'),
            'value' => $request->input('value'),
            'image' => $request->input('image'),
        ]);
        $result = '';
        foreach ($products as $product) {
            $result .= '<tr id="tr-' . $product->id . '">';
            $result .= '<td >';
            $result .= '<input form="deleteForm" type="checkbox" name="products[]" value="' . $product->id . '">';
            $result .= '</td >';
            $result .= '</td >';
            $result .= '<td>' . $product->id . '</td >';
            $result .= '<td >';
            $result .= '<img src="' . asset('storage/' . $product->image) . '" width="80">';
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->name;
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->old_price;
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->new_price;
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->brand ? $product->brand->name : '-';
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->category ? $product->category->name : '-';
            $result .= '</td >';
            $result .= '<td >';
            $result .= '<a class="btn-sm btn btn-primary"  href=' . route('shop.products.specifications', $product->id) . ' title="view specifications">' . count($product->specifications) . '</a><a class="btn-sm btn btn-primary featured" id="shop-product-' . $product->id . '" ' . ($product->featured ? 'title ="Remove this product from featured in home page" style="color:red !important"' : 'title ="Make this product featured in home page"') . '  data-content="' . $product->id . '"><i class="fa fa-fire"></i></a> 
             <a class="btn-sm btn btn-primary"  href=' . route('shop.products.images', $product->id) . ' title="view images"><i class="far fa-images"></i></a> <a title="edit product" class="btn-sm btn btn-primary"  href=' . route('shop.products.edit', $product->id) . '><i class="fa fa-edit"></i></a> <a style="color:#fff" class="btn-sm btn btn-danger delete" title="remove this product from offers!" data-content="' . $product->id . '"><i class="fa fa-times"></i></a>';
            $result .= ' </td >';
            $result .= ' </tr >';
        }
        return response()->json(['result' => $result, 'links' => $products->links()->render()], 200);
    }

    /**
     * Toggle featured products in home page
     */
    public function toggleFeatured($id)
    {
        $product = ShopProduct::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($product->featured) {
                $product->featured = 0;
                $product->save();
                DB::commit();
                return response()->json(['id' => $id, 'featured' => $product->featured, 'success' => 'Shop product has been removed from featured.']);
            } else {
                $product->featured = 1;
                $product->save();
                DB::commit();
                return response()->json(['id' => $id, 'featured' => $product->featured, 'success' => 'Shop product has been added as featured.']);
            }
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    public function searchByName(Request $request)
    {
        $part_of_name = trim($request->part_of_name);

        if (empty($part_of_name)) {
            return response()->json([]);
        }

        $products = ShopProduct::whereHas('translations', function ($query) use ($part_of_name) {
            $query->where('name', 'like', '%' . $part_of_name . '%')
                ->select('name', 'shop_product_id');
        })->select('id')->get();

        $formatted_products = [];

        foreach ($products as $product) {
            $formatted_products[] = ['id' => $product->id,
                'text' => $product->name,
            ];
        }

        return response()->json($formatted_products);
    }
	
  	//export products
    public function exportAllProducts(Request $request)
    {
        try {
            $products = ShopProduct::get();

            // Generate the Excel file and return it as a downloadable file
			return Excel::download(new ExportAllProducts($products), 'products_' . date('Y-m-d_H-i-s') . '.xlsx');
        } catch (\Exception $ex) {
            return response()->json([
                'error' => 'Error occurred, Please try again later.'
            ], 500);
        }
    }
}
