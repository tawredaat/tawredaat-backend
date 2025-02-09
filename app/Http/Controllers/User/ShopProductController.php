<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\FilterProductRequest;
use App\Models\ShopProduct;
use App\Models\Category;
use App\Repository\User\ShopProductRepo;
use App\Repository\User\CategoryRepo;
use Illuminate\Support\Facades\Cache;

class ShopProductController extends Controller
{

    protected $shopProductRepo;

    public function __construct(ShopProductRepo $shopProductRepo)
    {
        $this->shopProductRepo  = $shopProductRepo;
    }

    /**
     * get categories level one to filter shop products, best seller products, featured shop products.
     *
     * @return View
     */
    public function shop()
    {
        $categories = $this->LevelThreeCategories();
        $shop_banners = $this->getShopBanners();
        $featured_shop_products =$this->shopProductRepo->featuredShopProduct()['success']?json_decode(json_encode($this->shopProductRepo->featuredShopProduct()['object']['featuredShopProducts'])):[];
        $best_seller_shop_products =$this->shopProductRepo->bestSellerProducts()['success']?json_decode(json_encode($this->shopProductRepo->bestSellerProducts()['object']['bestSellerProducts'])):[];
        $lang_changed = $this->langChanged();
        return view('User.shop', compact('shop_banners','categories','featured_shop_products','best_seller_shop_products','lang_changed'));
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
        $shop_banners = $this->getShopBanners();
        $categories = $this->getLevelOneCategories();
        $this->shopProductRepo->setReq($request);
        $result = $this->shopProductRepo->show($id);
        if($result['success']){
            $product = json_decode(json_encode($result['object']['shopProduct']));
            $releatedProducts = json_decode(json_encode($result['object']['releatedProducts']));
            $lang_changed = $this->langChanged();
            return view('User.shopProduct', compact('shop_banners','product','lang_changed','categories','releatedProducts'));
        }
        elseif($result['validator'])
            abort(404);
        else
            abort(500);
    }
    /**
     * View All level three categories that in shop products(View More button).
     *
     * @return View
     */
    public function viewAllL3Categories()
    {

        $categories = $this->LevelThreeCategories();
        $shop_banners = $this->getShopBanners();
        $lang_changed = $this->langChanged();
        return view('User.shopL3Categories', compact('shop_banners','categories','lang_changed'));
    }
    /**
     * get shop products based on selected level three category.
     *
     *@param Request $request
     *@param $id
     *@param $name
     *@return View
     */
    public function getShopProductsByL3Category(Request $request,$id,$name)
    {
        $request->merge(['in_category' => $id]);
        $request->merge(['category_level' => 'level3']);
        $this->shopProductRepo->setReq($request);
        $result = $this->shopProductRepo->getShopProducts();
        $shop_banners = $this->getShopBanners();
        if($result['success']){
            $levelOneCategories =  $this->getLevelOneCategories();
            $shop_products = json_decode(json_encode($result['object']['ShopProducts']));
            $countProducts =$result['object']['total'];
            $category_selected = $result['object']['category'];
            $level1_category_selected = $category_selected->parent_category?$category_selected->parent_category->parent:0;
            $categories = $this->LevelThreeCategories();
            $brands = $result['object']['brands'];
            $specifications =json_decode(json_encode($result['object']['specifications']));
            $lang_changed = $this->langChanged();
            $shop_products_links = $result['object']['ShopProducts']->links();
            return view('User.shopProducts', compact('shop_banners','levelOneCategories','categories','brands','shop_products','countProducts','category_selected','level1_category_selected','shop_products_links','specifications','lang_changed'));
        }else
            abort(500);
    }

    /**
     * Filter Shop Products by Brands, Categories, Countries, Companies, Price range.
     *
     * @param FilterProductRequest $request
     *
     * @return View || \Illuminate\Http\JsonResponse
     */
    public function filterShopProducts(FilterProductRequest $request)
    {
        if($request->input('categories')){
            $request->merge(['in_category' => null]);
            $request->merge(['category_level' => null]);
        }

        $this->shopProductRepo->setReq($request);
        $result = $this->shopProductRepo->getShopProducts();
        $shop_banners = $this->getShopBanners();
        if($result['success']){
            if ($request->ajax()) {
                $shop_products = $result['object']['ShopProducts'];
                //Start URL and SEO Tags ******
                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                if(($pos = strpos($actual_link, "&")) !== FALSE)
                {
                    $fullPath = substr($actual_link, strpos($actual_link, "&") );
                    if($shop_products->nextPageUrl() !=null){
                        $next = $shop_products->nextPageUrl().$fullPath;
                    }else
                        $next=null;
                    if($shop_products->previousPageUrl() !=null){
                        $prev = $shop_products->previousPageUrl().$fullPath;
                    }else
                        $prev = null;
                }else{
                    $next = $shop_products->nextPageUrl();
                    $prev = $shop_products->previousPageUrl();
                }
                $shop_products_links = $shop_products->links();
                $shop_products = json_decode(json_encode($result['object']['ShopProducts']));
                $results = view('User.partials.filter_shop_products_results')->with([
                    'shop_products' => $shop_products,
                    'shop_products_links' => $shop_products_links,
                    'countProducts' => $result['object']['total'],
                    'filtered_brands' => $result['object']['filterd_brands'],
                    'filtered_categories' => $result['object']['filterd_categories'],
                    'filtered_countries' => $result['object']['filterd_countries'],
                    'filtered_specifications' => $result['object']['filterd_specifications'],
                    'fromPrice' => $result['object']['fromPrice'],
                    'toPrice' =>  $result['object']['toPrice'],
                ])->render();

                //End URL and SEO Tags ******
                return response()->json(['code' =>'200','result'=>$results,'next'=>$next,'prev'=>$prev,'actual_link'=>$actual_link]);
            } else {
                $shop_products = json_decode(json_encode($result['object']['ShopProducts']));
                return view('User.shopProducts')->with([
                    'shop_banners'=>$shop_banners,
                    'levelOneCategories' => $this->getLevelOneCategories(),
                    'shop_products' => $shop_products,
                    'countProducts' => $result['object']['total'],
                    'categories' => $this->LevelThreeCategories(),
                    'brands' =>$result['object']['brands'],
                    'specifications' =>json_decode(json_encode($result['object']['specifications'])),
                    'filtered_categories'=> $result['object']['filterd_categories'],
                    'filtered_brands'=> $result['object']['filterd_brands'],
                    'filtered_countries'=> $result['object']['filterd_countries'],
                    'filtered_specifications'=> $result['object']['filterd_specifications'],
                    'fromPrice' => $result['object']['fromPrice'],
                    'toPrice' => $result['object']['toPrice'],
                    'shop_products_links' => $result['object']['ShopProducts']->links(),
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
     * This is a helper function used to get all level one categories
     *
     * @return $lang_changed 0?1
     */
    private function getLevelOneCategories()
    {
        $levelOneCategories =$this->shopProductRepo->featuredCategories()['success']?json_decode(json_encode($this->shopProductRepo->featuredCategories()['object']['featuredCategories'])):[];
         return $levelOneCategories;
    }
    /**
     * This is a helper function used to get all level three categories that have products in shop
     *
     * @return $lang_changed 0?1
     */
    private function LevelThreeCategories()
    {
        $LevelThreeCategories =$this->shopProductRepo->LevelThreeCategories()['success']?json_decode(json_encode($this->shopProductRepo->LevelThreeCategories()['object']['LevelThreeCategories'])):[];
         return $LevelThreeCategories;
    }

    /**
     * This is a helper function used to get shop banners
     *
     * @return $lang_changed 0?1
     */
    private function getShopBanners()
    {
        $sliders =$this->shopProductRepo->sliders()['success']?json_decode(json_encode($this->shopProductRepo->sliders()['object']['sliders'])):[];
         return $sliders;
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