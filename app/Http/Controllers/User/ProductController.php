<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\FilterSpecificationRequest;
use App\Http\Requests\User\FilterProductRequest;
use App\Models\ProductSpecification;
use App\Models\Specification;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use App\Repository\User\ProductRepo;

class ProductController extends Controller
{

    protected $productRepo;

    public function __construct(ProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * get all products.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request)
    {
        $this->productRepo->setReq($request);
        $result = $this->productRepo->getProducts();
        if($result['success']){
            $products = $result['object']['products'];
            $products_ids = $result['object']['products_ids'];
            $countProducts = $result['object']['total'];
            if (Cache::has('products_countries'))
                $countries =  Cache::get('products_countries');
            else {
                Cache::put('products_countries', $result['object']['countries'],now()->addMinutes(1440));
                $countries =  Cache::get('products_countries');
            }
            if (Cache::has('products_categories'))
                $categories =  Cache::get('products_categories');
            else {
                Cache::put('products_categories',$result['object']['categories']);
                $categories =  Cache::get('products_categories');
            }
            if (Cache::has('products_companies'))
                $companies =  Cache::get('products_companies');
            else {
                Cache::put('products_companies',$result['object']['companies'],now()->addMinutes(1440));
                $companies =  Cache::get('products_companies');
            }
            if (Cache::has('products_brands'))
                $brands =  Cache::get('products_brands');
            else {
                Cache::put('products_brands',$result['object']['brands'],now()->addMinutes(1440));
                $brands =  Cache::get('products_brands');
            }
            $lang_changed = $this->langChanged();
            return view('User.products', compact('products','products_ids','countProducts', 'countries', 'categories', 'companies', 'brands','lang_changed'));
        }else
            abort(500);
    }
    /**
     * Show Product details.
     *
     * @param $name, $brand, $id
     *
     * @return View
     */
    public function show(Request $request, $name, $brand, $id)
    {
        $this->productRepo->setReq($request);
        $result = $this->productRepo->product($id);
        if($result['success']){
            $product = $result['object']['product'];
            $releatedProducts = Product::where('id', '!=', $id)->where('category_id', $product->category_id)->groupBy('id')->limit(6)->get();
            $lang_changed = $this->langChanged();
            return view('User.product', compact('product', 'releatedProducts','lang_changed'));
        }
        elseif($result['validator'])
            abort(404);
        else
            abort(500);
    }
    /**
     * Filter Products by Brands, Categories, Countries, Companies, Price range.
     *
     * @param FilterProductRequest $request
     *
     * @return View || \Illuminate\Http\JsonResponse
     */
    public function filterProducts(FilterProductRequest $request)
    {
        $this->productRepo->setReq($request);
        $result = $this->productRepo->getProducts();
        if($result['success']){
            if ($request->ajax()) {
                $products = $result['object']['products'];
                $results = view('User.partials.filter_products_results')->with([
                    'products' => $products,
                    'countProducts' => $result['object']['total'],
                    'brands' => $result['object']['filterd_brands'],
                    'categories' => $result['object']['filterd_categories'],
                    'countries' => $result['object']['filterd_countries'],
                    'companies' => $result['object']['filterd_companies'],
                    'specifications' => $result['object']['filterd_specifications'],
                    'fromPrice' => $result['object']['fromPrice'],
                    'toPrice' =>  $result['object']['toPrice'],
                ])->render();
                //Start URL and SEO Tags ******
                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                if(($pos = strpos($actual_link, "&")) !== FALSE)
                {
                    $fullPath = substr($actual_link, strpos($actual_link, "&") );
                    if($products->nextPageUrl() !=null){
                        $next = $products->nextPageUrl().$fullPath;
                    }else
                        $next=null;
                    if($products->previousPageUrl() !=null){
                        $prev = $products->previousPageUrl().$fullPath;
                    }else
                        $prev = null;
                }else{
                    $next = $products->nextPageUrl();
                    $prev = $products->previousPageUrl();
                }
                //End URL and SEO Tags ******
                return response()->json(['code' =>'200','result'=>$results,'next'=>$next,'prev'=>$prev,'actual_link'=>$actual_link]);
            } else {
                return view('User.products_filter')->with([
                    'products' => $result['object']['products'],
                    'countProducts' => $result['object']['total'],
                    'products_ids' => $result['object']['products_ids'],
                    'countries' => $result['object']['countries'],
                    'categories' => $result['object']['categories'],
                    'companies' => $result['object']['companies'],
                    'brands' =>$result['object']['brands'],
                    'specifications' =>json_decode(json_encode($result['object']['specifications'])),
                    // 'specifications' => Specification::with('values')->whereIn('id', ProductSpecification::whereIn('product_id', $products_ids)->whereNotNull('value')->distinct()->pluck('specification_id')->toArray())->get(),
                    'fromPrice' => $result['object']['fromPrice'],
                    'toPrice' => $result['object']['toPrice'],
                    'filterd_brands' => $result['object']['filterd_brands'],
                    'filterd_categories' => $result['object']['filterd_categories'],
                    'filterd_countries' => $result['object']['filterd_countries'],
                    'filterd_companies' => $result['object']['filterd_companies'],
                    'filterd_specifications' => $result['object']['filterd_specifications'],
                    'key' => $result['object']['key'],
                    'brand' => $result['object']['brand'],
                    'company' => $result['object']['company'],
                    'category_name' => $result['object']['category'],
                    'categoryID' => $result['object']['category_id'],
                    'category_level' => $result['object']['category_level'],
                    'lang_changed' => $this->langChanged(),
                ]);
            }
        }
        else{
            if ($request->ajax())
                return response()->json(['code' =>'500','result'=>null,'next'=>null,'prev'=>null,'actual_link'=>null]);
            else
                abort(500);
        }
    }


    /**
     * This is a helper function used to get previous language locale
     *
     * @return $lang_changed 0?1
     */
    private function langChanged(){
        $lang_changed = 0;
        if(session()->has('current_lang') && session()->get('current_lang') !=app()->getLocale())
            $lang_changed = 1;
        session()->put('current_lang',app()->getLocale());
        return $lang_changed;
    }

}
