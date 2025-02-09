<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteSelectedProductsRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Products';
        $SubTitle = 'View';
        return view('Admin._products.index', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Display a listing of the resource.
     */
    public function specifications($id)
    {
        $MainTitle = 'Shop Products';
        $SubTitle = 'Specifications';
        $product = Product::findOrFail($id);
        return view('Admin._products.specifications', compact('MainTitle', 'SubTitle', 'product'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function products()
    {
        ini_set('memory_limit', '1024M'); // or you could use 1G
        $records = Product::all();
        return Datatables::of($records)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Products';
        $SubTitle = 'Add';
        $level3Categories = Category::where('level', 'level3')->get();
        $brands = Brand::all();
        return view('Admin._products.create', compact('MainTitle', 'SubTitle', 'level3Categories', 'brands'));
    }

    /**
     * Show the form for upload CSV file.
     */
    public function import()
    {
        dd(1);
        $MainTitle = 'Products';
        $SubTitle = 'Import Products from CSV ';
        return view('Admin._products.import', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            //upload new image file
            if ($request->file('image')) {
                $image = UploadFile::UploadSinglelFile($request->file('image'), 'products');
            } else {
                $image = null;
            }

            //upload new image file
            if ($request->file('mobileimg')) {
                $mob_image = UploadFile::UploadSinglelFile($request->file('mobileimg'), 'products');
            } else {
                $mob_image = null;
            }

            //upload new PDF file
            if ($request->file('pdf')) {
                $pdf = UploadFile::UploadSinglelFile($request->file('pdf'), 'products');
            } else {
                $pdf = null;
            }

            Product::create([
                'image' => $image,
                'mobileimg' => $mob_image,
                'pdf' => $pdf,
                'category_id' => $input['category_id'],
                'brand_id' => $input['brand_id'],
                'sku_code' => $input['sku_code'],
                'video' => $input['video'],
                'en' => [
                    'name' => $input['name_en'],
                    'title' => $input['title_en'],
                    'alt' => $input['alt_en'],
                    'description' => $input['description_en'],
                    'description_meta' => $input['description_meta_en'],
                    'keywords_meta' => $input['keywords_meta_en'],
                    'keywords' => $input['keywords_en'],
                ],
                'ar' => [
                    'name' => $input['name_ar'],
                    'title' => $input['title_ar'],
                    'alt' => $input['alt_ar'],
                    'description' => $input['description_ar'],
                    'description_meta' => $input['description_meta_ar'],
                    'keywords_meta' => $input['keywords_meta_ar'],
                    'keywords' => $input['keywords_ar'],

                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Product data has been created succssfuly');
            return redirect()->route('products.index');
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
        $MainTitle = 'Products';
        $SubTitle = 'Edit';
        $level3Categories = Category::where('level', 'level3')->get();
        $product = Product::findOrFail($id);
        $brands = Brand::all();
        return view('Admin._products.edit', compact('MainTitle', 'SubTitle', 'product', 'level3Categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $input = $request->all();
        $product = Product::findOrFail($id);
        DB::beginTransaction();
        try {
            //upload  new image file
            if ($request->file('image')) {
                //Remove old file
                UploadFile::RemoveFile($product->image);
                $product->image = UploadFile::UploadSinglelFile($request->file('image'), 'products');
            }

            //upload  new image file
            if ($request->file('mobileimg')) {
                //Remove old file
                UploadFile::RemoveFile($product->mobileimg);
                $product->mobileimg = UploadFile::UploadSinglelFile($request->file('mobileimg'), 'products');
            }

            //upload  new PDF file
            if ($request->file('pdf')) {
                if ($product->pdf) {
                    //Remove old file
                    UploadFile::RemoveFile($product->pdf);
                }
                $product->pdf = UploadFile::UploadSinglelFile($request->file('pdf'), 'products');
            }
            $product->category_id = $input['category_id'];
            $product->brand_id = $input['brand_id'];
            $product->sku_code = $input['sku_code'];
            $product->video = $input['video'];
            $product->translate('en')->name = $input['name_en'];
            $product->translate('ar')->name = $input['name_ar'];
            $product->translate('en')->title = $input['title_en'];
            $product->translate('ar')->title = $input['title_ar'];
            $product->translate('en')->alt = $input['alt_en'];
            $product->translate('ar')->alt = $input['alt_ar'];
            $product->translate('en')->description = $input['description_en'];
            $product->translate('ar')->description = $input['description_ar'];
            $product->translate('en')->description_meta = $input['description_meta_en'];
            $product->translate('ar')->description_meta = $input['description_meta_ar'];
            $product->translate('en')->keywords_meta = $input['keywords_meta_en'];
            $product->translate('ar')->keywords_meta = $input['keywords_meta_ar'];
            $product->translate('en')->keywords = $input['keywords_en'];
            $product->translate('ar')->keywords = $input['keywords_ar'];
            $product->save();
            DB::commit();
            session()->flash('_added', 'Product data has been updated succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            return response();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        //Remove old multiple file
        if (count($product->images)) {
            UploadFile::RemoveMultiFiles('App\Models\Product', $id);
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
        return response()->json([], 200);
    }

    public function deleteSelected(DeleteSelectedProductsRequest $request)
    {
        $products = Product::whereIn('id', $request->input('products', []))->get();

        foreach ($products as $product) {
            //Remove old multiple file
            if (count($product->images)) {
                UploadFile::RemoveMultiFiles('App\Models\Product', $product->id);
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
        session()->flash('_added', 'Products data has been deleted successfully');
        return back();
    }

    public function deleteAll()
    {
        $products = Product::all();

        foreach ($products as $product) {
            //Remove old multiple file
            if (count($product->images)) {
                UploadFile::RemoveMultiFiles('App\Models\Product', $product->id);
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
        session()->flash('_added', 'Products data has been deleted successfully');
        return back();
    }

    /************************************************************
     * Module of Upload Multiple images to single product.
     */
    public function viewImages($id)
    {
        $product = Product::findOrFail($id);
        $MainTitle = 'Products';
        $SubTitle = "Upload images of ";
        return view('Admin._products.images', compact('product', 'MainTitle', 'SubTitle'));
    }

    /**
     * return product images to be displayed in DT.
     */
    public function ProductsImagess($id)
    {

        $records = File::where('model_id', $id)->where('model_type', 'App\Models\Product')->get();
        return Datatables::of($records)->make(true);
    }

    /**
     * store product images in File Table.
     */
    public function uploadImages(Request $request, $id)
    {

        $product = Product::findOrFail($id);
        DB::beginTransaction();
        try {
            //upload multiple files
            UploadFile::UploadMultiFiles($request->file('images'), 'productsImages', 'App\Models\Product', $product->id);

            DB::commit();
            return response()->json(['success' => 'done']);
            // return redirect()->route('subscriptions.index');
        } catch (\Exception $exception) {
            DB::rollback();
            return abort(500);
        }
    }

    /**
     * delete a single image from product images .
     */
    public function deleteImage($id)
    {
        $image = File::findOrFail($id);
        //Remove old file
        if ($image->path) {
            UploadFile::RemoveFile($image->path);
        }
        $image->delete();
        return response()->json([], 200);
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
        //return $request->all();
        $pagination = 0;
        if ($request->input('pagination') == 'true') {
            // return "haha";
            $pagination = 500;
        } else {
            $pagination = 10;
        }

        //return $pagination;
        ini_set('memory_limit', '1024M'); // or you could use 1G
        $products = Product::when($request->input('column'), function ($query) use ($request) {
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
            ->select(['id', 'brand_id', 'category_id', 'image', 'created_at'])
            ->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
                $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
            })->when($request->input('column') == 'id', function ($query) use ($request) {
            return $query->where('id', 'like', '%' . $request->input('value') . '%');
        })->paginate($pagination)->appends([
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
            $result .= '<a class="btn-sm btn btn-primary"  href=' . route('products.view.specifications', $product->id) . ' title="view specifications">' . count($product->specifications) . '</a> <a title="view images" class="btn-sm btn btn-primary"  href=' . route('products.images', $product->id) . '><i class="far fa-images"></i></a> <a title="edit product" class="btn-sm btn btn-primary"  href=' . route('products.edit', $product->id) . '><i class="fa fa-edit"></i></a> <a title="delete product" style="color:#fff" class="btn-sm btn btn-danger delete" data-content="' . $product->id . '"><i class="fa fa-trash"></i></a>';
            $result .= ' </td >';
            $result .= ' </tr >';
        }
        return response()->json(['result' => $result, 'links' => $products->links()->render()], 200);
    }
}
