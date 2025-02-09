<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\FilterBrandRequest;
Use App\Models\BrandVisitor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Repository\User\BrandRepo;
use App\Repository\User\ProductRepo;
class BrandController extends Controller
{

    protected $productRepo;
    protected $brandRepo;

    public function __construct(BrandRepo $brandRepo,ProductRepo $productRepo)
    {
        $this->brandRepo = $brandRepo;
        $this->productRepo = $productRepo;
    }
	/**
     * Get all brands.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request)
	{
        $this->brandRepo->setReq($request);
        $result = $this->brandRepo->getBrands();
        if($result['success']){
            if (!session()->has('brand')) {
                session()->put('brand', Str::random(10));
                BrandVisitor::create(['user_id'=>UserID(),'brand'=>session()->get('brand')]);
            }elseif(session()->has('brand') AND isLogged())
                BrandVisitor::where('brand',session()->get('brand'))->update(['user_id'=>UserID()]);
            $brands = $result['object']['brands'];
            $countBrands = $result['object']['total'];
            if (Cache::has('brands_countries'))
                $countries =  Cache::get('brands_countries');
            else{
                Cache::put('brands_countries', $result['object']['countries'],now()->addMinutes(1440));
                $countries =  Cache::get('brands_countries');
            }
             if (Cache::has('brands_categories'))
                $categories =  Cache::get('brands_categories');
            else {
                Cache::put('brands_categories', $result['object']['categories'],now()->addMinutes(1440));
                $categories =  Cache::get('brands_categories');
            }
            if (Cache::has('brands_companies'))
                $companies =  Cache::get('brands_companies');
            else{
                Cache::put('brands_companies',$result['object']['companies'],now()->addMinutes(1440));
                $companies =  Cache::get('brands_companies');
            }
            $lang_changed = $this->langChanged();
            return view('User.brands',compact('brands','countBrands','countries','categories','companies','lang_changed'));

        }else
            abort(500);
	}
	/**
     * Show brand page details.
     *
     * @param Request $request, $name, $id
     *
     * @return View
     */
	public function show(Request $request,$name,$id)
	{
        $this->brandRepo->setReq($request);
        $result = $this->brandRepo->brand($id);
        if($result['success']){
            $brand          = $result['object']['brand'];
            $categories     = $result['object']['categories'];
            $relatedBrands  = $result['object']['relatedBrands'];
            $keywords       = $result['object']['keywords'];
            $lang_changed   = $this->langChanged();
            return view('User.brand',compact('brand','categories','relatedBrands','keywords','lang_changed'));
        }
        elseif($result['validator'])
            abort(404);
        else
            abort(500);
    }
    /**
     * Filter brands by categories or companies or countries  or keywords
     *
     * @param FilterBrandRequest $request
     *
     * @return View OR \Illuminate\Http\JsonResponse
     */
    public function filterBrands(FilterBrandRequest $request){
        $this->brandRepo->setReq($request);
        $result = $this->brandRepo->getBrands();
        if($result['success']){
            if($request->ajax()){
                $brands = $result['object']['brands'];
                $results =  view('User.partials.filter_brands_results')->with([
                    'brands'=>$brands,
                    'countBrands'=>$result['object']['total'],
                    'companies'=>$result['object']['filterd_companies'],
                    'categories'=>$result['object']['filterd_categories'],
                    'countries'=>$result['object']['filterd_countries'],
                ])->render();
                //URL and SEO Tags
                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                if(($pos = strpos($actual_link, "&")) !== FALSE){
                    $fullPath = substr($actual_link, strpos($actual_link, "&") );
                    if($brands->nextPageUrl() !=null)
                        $next = $brands->nextPageUrl().$fullPath;
                    else
                        $next=null;
                    if($brands->previousPageUrl() !=null)
                        $prev = $brands->previousPageUrl().$fullPath;
                    else
                        $prev = null;
                }else{
                    $next = $brands->nextPageUrl();
                    $prev = $brands->previousPageUrl();
                }
                return response()->json(['code' =>'200','result'=>$results,'next'=>$next,'prev'=>$prev,'actual_link'=>$actual_link]);
            }else{
                return view('User.brands_filter')->with([
                    'brands'=>$result['object']['brands'],
                    'countBrands'=>$result['object']['total'],
                    'filterd_companies'=>$result['object']['filterd_companies'],
                    'filterd_categories'=>$result['object']['filterd_categories'],
                    'filterd_countries'=>$result['object']['filterd_countries'],
                    'countries'  => $result['object']['countries'],
                    'categories' =>  $result['object']['categories'],
                    'companies'  => $result['object']['companies'],
                    'category'=>$result['object']['category'],
                    'keyword'=>$result['object']['keyword'],
                    'key'=>$result['object']['key'],
                    'lang_changed' => $this->langChanged(),
                ])->render();
            }
        }else{
            if ($request->ajax())
                return response()->json(['code' =>'500','result'=>null,'next'=>null,'prev'=>null,'actual_link'=>null]);
            else
                abort(500);
        }
    }
    /**
     * get brands realted to an  category
     *
     * @param Request $request, $name,$id
     *
     * @return View
     */
	public function BrandCategory(Request $request,$name,$id)
	{
        $request->merge(['in_category'=>$id]);
        $this->brandRepo->setReq($request);
        $result = $this->brandRepo->getBrands();
        if($result['success']){
            $brands = $result['object']['brands'];
            $countBrands = $result['object']['total'];
            $countries = $result['object']['countries'];
            $categories = $result['object']['categories'];
            $companies = $result['object']['companies'];
            $category = $result['object']['category'];
            $lang_changed = $this->langChanged();
            return view('User.brands',compact('brands','countBrands','countries','categories','companies','category','lang_changed'));
        }else
            abort(500);
	}
    /**
     * get brands realted to a tag(keyword)
     *
     * @param Request $request,$id
     *
     * @return View
     */
    public function BrandKeywords(Request $request,$id)
    {
        $request->merge(['in_keyword'=>$request->input('tag')]);
        $this->brandRepo->setReq($request);
        $result = $this->brandRepo->getBrands();
        if($result['success']){
            $brands = $result['object']['brands'];
            $countBrands = $result['object']['total'];
            $countries = $result['object']['countries'];
            $categories = $result['object']['categories'];
            $companies = $result['object']['companies'];
            $keyword = $result['object']['keyword'];
            $lang_changed = $this->langChanged();
            return view('User.brands',compact('brands','countBrands','countries','categories','companies','keyword','lang_changed'));
        }else
            abort(500);
    }
    /**
     * Get Products related to a brand
     *
     * @param Request $request,$name,$id
     *
     * @return View
     */
    public function BrandProducts(Request $request,$name,$id)
    {
        $request->merge(['in_brand'=>$id]);
        $this->productRepo->setReq($request);
        $result = $this->productRepo->getProducts();
        if($result['success']){
            $products = $result['object']['products'];
            $countProducts = $result['object']['total'];
            $products_ids = $result['object']['products_ids'];
            $categories = $result['object']['categories'];
            $brand = $result['object']['brand'];
            $lang_changed = $this->langChanged();
            return view('User.products_brands',compact('products','products_ids','countProducts','brand','categories','lang_changed'));
        }else
            abort(500);
    }
    /**
     * Get companies(distributors) related to a brand
     *
     * @param Request $request,$name,$id
     *
     * @return View
     */
    public function BrandCompanies(Request $request,$name,$id)
    {
        $this->brandRepo->setReq($request);
        $result = $this->brandRepo->companies($id);
        if($result['success'])
        {
            $companies = $result['object']['brandCompanies'];
            $companyBrandTypes = $result['object']['types'];
            $brand = $result['object']['brand'];
            $lang_changed = $this->langChanged();
            return view('User.brand_distributors',compact('companies','companyBrandTypes','brand','lang_changed'));
        }
        elseif($result['validator'])
            abort(404);
        else
            abort(500);
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
