<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\CompanyProduct;
use App\Models\Unit;
use App\Http\Requests\Company\StoreProductsRequest;
use App\Http\Requests\Company\UpdateCompanyProduct;
use Illuminate\Support\Facades\DB;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function new_index()
    {
        $units     = Unit::all();
        $products  = CompanyProduct::with('unit')->where('company_id',CompanyID())->get();
        $MainTitle = 'Products';
        $SubTitle  = 'View';
        return view('Company.products.index',compact('MainTitle','SubTitle','products','units'));
    }
    /**
     * Show the form to select an brand.
     */
    public function selectBrands()
    {
        $MainTitle = 'Products';
        $SubTitle  = 'Assign';
        $approved_brands = CompanyProduct::where('company_id',auth('company')->user()->id)->where('approve',2)->groupBy('brand_id')->pluck('brand_id')->toArray();
        $brands    = Brand::find($approved_brands);
        return view('Company.products.selectBrands',compact('MainTitle','SubTitle','brands'));
    }
        /**
     * Show the data of l1 categories based on selected brands.
     */
    public function selectedBrands(Request $request)
    {
        $MainTitle = 'Products';
        $SubTitle  = 'Assign';
        $brand_id   =  $request->brand_id;
        //get brand that selected
        $brand      = Brand::where('id',$brand_id)->with('brandCategories')->first();
        //get level3 categories of brand selected
        $l3Categories = $brand->brandCategories;
        //get levels2 of levels3 that belongs to brands selected
        $l2Categories = [];
        foreach ($l3Categories as $bc) {
            $l2Category = Category::where('level','level2')->where('id',$bc->category->parent)->pluck('parent');
            if (!in_array($l2Category, $l2Categories))
                array_push($l2Categories, $l2Category);
        }
        //get levels1 that belongs to levels2 that belongs to levels3 that belongs to brand
        $l1Categories = [];
        foreach ($l2Categories as $l2) {
            $l1Category = Category::where('level','level1')->where('id',$l2)->first();
            if (!in_array($l1Category, $l1Categories))
                array_push($l1Categories, $l1Category);
        }
        return view('Company.products.selectL1Categories',compact('MainTitle','SubTitle','l1Categories'));
    }
    /**
     * Filter level two categories based on level one that selected.
     */
    public function selectedL1Categories(Request $request){
        $MainTitle = 'Products';
        $SubTitle  = 'Assign';
        $brand = Brand::where('id',$request->brand)->with('brandCategories')->first();
        $brandCategories = $brand->brandCategories;
        //get level two using check all
            $l2Categories = [];
            foreach ($brandCategories as $bc) {
                $l2Category = Category::where('level','level2')->where('id',$bc->category->parent)->whereIn('parent',$request->categories)->first();
                if (!in_array($l2Category, $l2Categories))
                    array_push($l2Categories, $l2Category);
            }
        $l1Categories = Category::where('level','level1')->whereIn('id',$request->categories)->get();
        return view('Company.products.selectL2Category',compact('l1Categories','MainTitle','SubTitle','l2Categories'));
    }
    /**
     * Filter level one categories based on level two that selected.
     */
    public function selectedL2Categories(Request $request){
        $MainTitle = 'Products';
        $SubTitle  = 'Assign';
        $brand = Brand::where('id',$request->brand)->with('brandCategories')->first();
        $brandCategories = $brand->brandCategories;
        //get level two using check all
            $l3Categories = [];
            foreach ($brandCategories as $bc) {
                $l3Category = Category::where('level','level3')->where('id',$bc->category_id)->whereIn('parent',$request->categories)->first();
                if (!in_array($l3Category, $l3Categories))
                    array_push($l3Categories, $l3Category);
            }
        $l2Categories = Category::where('level','level2')->whereIn('id',$request->categories)->get();
        return view('Company.products.selectL3Category',compact('l2Categories','MainTitle','SubTitle','l3Categories'));
    }
    /**
     * Filter products based on level two that selected.
     */
    //final filter(show products)
    public function selectedL3Categories(Request $request){
        set_time_limit(0);
        ini_set('memory_limit', '1024M'); // or you could use 1G
        $MainTitle = 'Products';
        $SubTitle  = 'Assign';
        $assignedPros = CompanyProduct::whereNotNull('product_id')->where('company_id',auth('company')->user()->id)->pluck('product_id')->toArray();
        $approved_brands = CompanyProduct::where('company_id',auth('company')->user()->id)->where('approve',2)->groupBy('brand_id')->pluck('brand_id')->toArray();
        if(in_array($request->brand,$approved_brands))
            $products = Product::whereIn('category_id',$request->categories)->where('brand_id',$request->brand)->whereNotIn('id',$assignedPros)->get();
        else
            $products = Product::whereIn('category_id',$request->categories)->whereNotIn('id',$assignedPros)->get();
        $l3Categories = Category::where('level','level3')->whereIn('id',$request->categories)->get();
        return view('Company.products.selectProducts',compact('l3Categories','MainTitle','SubTitle','products'));
    }
    /**
     *assign seleted products to company.
     */
    public function selectedProducts (Request $request){
        set_time_limit(0);
        ini_set('memory_limit', '1024M'); // or you could use 1G
       $input = $request->all();
        DB::beginTransaction();
        try {
            for($i=0;$i<count($input['products']);$i++)
            {
                CompanyProduct::create([
                    'company_id'  => auth('company')->user()->id,
                    'product_id'  => $input['products'][$i],
                    'brand_id'    => $input['brand'],
                ]);
            }
            DB::commit();
            session()->flash('_added','Products has been assigned succssfuly');
            return redirect()->route('company.products.view');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    //get assigned products data from DB, then return data in html table
    public function getProducts(Request $request)
    {
        ini_set('memory_limit', '1024M'); // or you could use 1G

        $products = CompanyProduct::when($request->input('column'), function ($query) use ($request) {

            if ($request->input('column') == 'product_name')
                return $query->whereHas('product', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });

            if ($request->input('column') == 'brand')
                return $query->whereHas('brand', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
                });
            if ($request->input('column') == 'unit')
                return $query->whereHas('unit', function ($query) use ($request) {
                    return $query->whereHas('translations', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->input('value') . '%');
                    });
            });
        })->
        with(['product' => function ($query) use ($request) {
            $query->select(['id','image']);
        },
        'brand' => function ($query) use ($request) {
            $query->select(['id']);
        }])->select(['id', 'product_id', 'brand_id','unit_id','price','discount','qty', 'company_id'])
            ->when($request->input('column') == 'price', function ($query) use ($request) {
                return $query->where('price', 'like', '%' . $request->input('value') . '%');
            })
            ->when($request->input('column') == 'qty', function ($query) use ($request) {
                return $query->where('qty', 'like', '%' . $request->input('value') . '%');
            })
            ->when($request->input('column') == 'disc', function ($query) use ($request) {
                return $query->where('discount', 'like', '%' . $request->input('value') . '%');
            })
            ->where('company_id',CompanyID())->paginate(10)->appends([
                'column' => $request->input('column'),
                'value' => $request->input('value'),
                'image' => $request->input('image')
            ]);

        $result = '';
        foreach ($products as $product) {
            $result .= '<tr id="tr-' . $product->id . '">';
            $result .= '<td >';
            $result .= '<img src="' . asset('storage/'.$product->product->image) . '" width="80">';
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->product?$product->product->name:'---';
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->brand?$product->brand->name:'-';
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->price;
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->unit ? $product->unit->name : '-';
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->qty;
            $result .= '</td >';
            $result .= '<td >';
            $result .= $product->discount;
            $result .= '</td >';
            $result .= '<td >';
            $result .='<a style="color:#fff;font-size: 12px;margin:2px;" class="btn btn-danger delete btn-sm" data-content="'.$product->id.'"><i class="fa fa-trash"></i></a>'
                . '<a style="color:#fff;font-size: 12px;margin: 2px;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModalCenter'.$product->id.'"><i class="fa fa-edit"></i></a>';
            $result .= ' </td >';
            $result .= ' </tr >';
        }
        return response()->json(['result' => $result, 'links' => $products->links()->render()], 200);
    }
    //////////////////////////////////// Old Assign Products/////////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units     = Unit::all();
        $products  = CompanyProduct::with('unit')->where('company_id',CompanyID())->get();
        $MainTitle = 'Products';
        $SubTitle  = 'View';
        return view('Company._products.index',compact('MainTitle','SubTitle','products','units'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Products';
        $SubTitle  = 'Assign';
        $approved_brands = CompanyProduct::where('company_id',auth('company')->user()->id)->where('approve',2)->groupBy('brand_id')->pluck('brand_id')->toArray();
        $brands    = Brand::find($approved_brands);
        return view('Company._products.create',compact('MainTitle','SubTitle','brands'));
    }
     /**
     * Filter level one categories based on brands that have level three.
     */
    public function levelOneOfSelectedBrand(Request $request){
        $brand_id   =  $request->brandID;
        //get brand that selected
        $brand      = Brand::where('id',$brand_id)->with('brandCategories')->first();
        //get level3 categories of brand selected
        $l3Categories = $brand->brandCategories;
        //get levels2 of levels3 that belongs to brands selected
        $l2Categories = [];
        foreach ($l3Categories as $bc) {
            $l2Category = Category::where('level','level2')->where('id',$bc->category->parent)->pluck('parent');
            if (!in_array($l2Category, $l2Categories))
                array_push($l2Categories, $l2Category);
        }
        //get levels1 that belongs to levels2 that belongs to levels3 that belongs to brand
        $l1Categories = [];
        foreach ($l2Categories as $l2) {
            $l1Category = Category::where('level','level1')->where('id',$l2)->first();
            if (!in_array($l1Category, $l1Categories))
                array_push($l1Categories, $l1Category);
        }
        return json_encode($l1Categories);
    }
    /**
     * Filter level two categories based on level one that selected.
     */
    public function levelTwoOfSelectedLevel1(Request $request){

        $brand = Brand::where('id',$request->brand)->with('brandCategories')->first();
        $brandCategories = $brand->brandCategories;
        //get level two using check all
            $l2Categories = [];
            foreach ($brandCategories as $bc) {
                $l2Category = Category::where('level','level2')->where('id',$bc->category->parent)->whereIn('parent',$request->l1CategoriesIDs)->first();
                if (!in_array($l2Category, $l2Categories))
                    array_push($l2Categories, $l2Category);
            }
        return json_encode($l2Categories);
    }
    /**
     * Filter level three categories based on level two that selected.
     */
    public function levelThreeOfSelectedLevel2(Request $request){
        $brand = Brand::where('id',$request->brand)->with('brandCategories')->first();
        $brandCategories = $brand->brandCategories;
        //get level two using check all
            $l3Categories = [];
            foreach ($brandCategories as $bc) {
                $l3Category = Category::where('level','level3')->where('id',$bc->category_id)->whereIn('parent',$request->l2CategoriesIDs)->first();
                if (!in_array($l3Category, $l3Categories))
                    array_push($l3Categories, $l3Category);
            }
        return json_encode($l3Categories);
    }
    /**
     * Filter products based on level three that selected.
     */
    public function products(Request $request){
        $assignedPros = CompanyProduct::where('company_id',auth('company')->user()->id)->pluck('product_id');
        $products = Product::whereIn('category_id',$request->l3CategoriesIDs)->where('brand_id',$request->brand)->whereNotIn('id',$assignedPros)->get();
        return json_encode($products);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request)
    {
       $input = $request->all();
        DB::beginTransaction();
        try {
            for($i=0;$i<count($input['products']);$i++)
            {
                CompanyProduct::create([
                    'company_id'  => auth('company')->user()->id,
                    'product_id'  => $input['products'][$i],
                    'brand_id'    => $input['brand_id'],
                ]);
            }
            DB::commit();
            session()->flash('_added','Products has been assigned succssfuly');
            return redirect()->route('company.products.index');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateCompanyProduct $request, $id)
    {
        $input = $request->all();
        //get unit that seleted to appear after submit in product
        $unit  = Unit::findOrFail($input['unit_id']);
        DB::beginTransaction();
        try {
            $data = [
                'unit_id'       => $input['unit_id'],
                'price'         => $input['price'],
                'qty'           => $input['qty'],
                'discount'      => $input['discount'],
                'discount_type' => $input['discount_type']
            ];
            CompanyProduct::where('id',$id)->update($data);
            DB::commit();
           return response()->json(['id'=>$id,'data'=>$data, 'unit'=> $unit->name], 200);
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $product = CompanyProduct::findOrFail($id);
        if ($product->company_id==CompanyID())
            $product->delete();
        return response()->json(['id'=>$id,'success' => 'Data is successfully deleted']);

    }
}
