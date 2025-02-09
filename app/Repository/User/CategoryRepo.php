<?php

namespace App\Repository\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\ShopProduct;
use App\Models\Specification;
use App\Models\ShopProductSpecification;
use App\Models\BrandCategory;
use App\Models\Brand;
use App\Models\Seo;
use App\Models\CartItem;
use App\Models\CategoryBanner;
use App\Http\Resources\Collections\CategoriesCollection;
use App\Http\Resources\Collections\SpecificationsCollection;
use App\Http\Resources\ShowCategoryResource;
use App\Http\Resources\CategoryBannerResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryNamesOnlyResource;
use App\Http\Resources\ShopProductResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategorySeoResource;
use App\Http\Resources\CategoryWithSubCategoriesWithoutProductsResource;
use App\Http\Resources\BrandSeoResource;
use App\Http\Resources\PageSeoResource;
use App\Helpers\General;
use App\Http\Resources\BundelBannerResource;
use App\Models\Banner;
use Illuminate\Support\Facades\Cache;

class CategoryRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Get featured categoeis..
     *
     * @return CategoriesCollection
     */
    public function featuredCategories(){
        try{
            $results['categories'] = new CategoriesCollection(Category::where('featured',1)->where('level','level1')->get());
            return $this->result = ['validator' => null, 'success' => 'Featured Categoreis', 'errors' => null,'object'=>$results];
        }catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' =>$exception,'object'=>null];
        }
    }
    
    public function allLevelOne()
    {
        try {
            // Get the level one categories with their children (filtered by 'show' equals 1)
            $categories = Category::where('level', 'level1')
                                  ->where('show', 1)
                                  ->get();
            
            // Create a resource collection from the categories
            $results['levelOneCategories'] = CategoryResource::collection($categories);
        
            return $this->result = [
                'validator' => null,
                'success' => 'all level one categories',
                'errors' => null,
                'object' => $results
            ];
        } catch (\Exception $exception) {
            return $this->result = [
                'validator' => null,
                'success' => null,
                'errors' => $exception,
                'object' => null
            ];
        }
    }
    /**
     * get level two categories based on level one.
     *
     *
     * @return colloection of data
     */
    public function levelOne($id)
    {
        try{
            $category = Category::where('level','level1')->find($id);
            if($category){
                $results['levelTwoCategories'] = new CategoriesCollection($category->childs);
                return $this->result = ['validator' => null, 'success' => 'Level two based on level one categories','errors'=>null,'object'=>$results];
            }
            else
                return $this->result = ['validator' => 'This category is not found!', 'success' => null,'errors'=>null,'object'=>null];
        }catch (\Exception $exception) {
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }
    /**
     * get level three categories based on level two.
     *
     *
     * @return colloection of data
     */
    public function levelTwo($id)
    {
        try{
            $category = Category::where('level','level2')->find($id);
            if($category){
                $results['levelThreeCategories'] = new CategoriesCollection($category->childs);
                return $this->result = ['validator' => null, 'success' => 'Level three based on level two categories','errors'=>null,'object'=>$results];
            }
            else
                return $this->result = ['validator' => 'This category is not found!', 'success' => null,'errors'=>null,'object'=>null];
        }catch (\Exception $exception) {
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }
    /**
     * get level 3 categories.
     *
     *
     * @return colloection of data
     */
    public function levelThreeCategories()
    {
        try{
            $results['levelThreeCategories'] = new CategoriesCollection(Category::where('level','level3')->get());
            return $this->result = ['validator' => null, 'success' => 'Level three categories','errors'=>null,'object'=>$results];
        }catch (\Exception $exception) {
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }

    public function show($id)
    {
        try{
            $category = Category::with('childs')->where('id', $id)->first();
            
            if($category->level == 'level1')
            {
                
                $OneAndTwoAndThree = [];
                $levelTwo   = $category->childs->pluck('id');
                $levelThree = Category::whereIn('parent' , $levelTwo)->pluck('id');
                $categories = Category::with('childs.childs')
                    ->where('id', $id)
                    ->get();
                    
                $categories = Category::with('childs.childs')
                    ->where('id', $id)
                    ->get();

                // Pluck all IDs of level one, level two, and level three categories
                $levelOneIds = $categories->pluck('id');
                $levelTwoIds = $categories->pluck('childs')->flatten()->pluck('id');
                $levelThreeIds = $categories->pluck('childs')->flatten(1)->pluck('childs')->flatten()->pluck('id');

                $OneAndTwoAndThree = $levelTwo->merge($levelThree)->merge($category->id);                
                $brandIds =  BrandCategory::whereIn('category_id' , $OneAndTwoAndThree)->pluck('brand_id')->unique();
                 
                $results['category_breadcrumbs'] = 
                [
                    'tiny_category' => null,/* CategoryResource::collection(Category::whereIn('parent' , $levelTwo)->get()), */
                    'subcategory'   => null,/* $this->levelOne($id), */
                    'category'      => new CategoryResource($category),
                ];

                $results['brands'] = BrandResource::collection(Brand::whereIn('id' , $brandIds)->get());
                $products_ids=[] ;
                $input_specifications = request()->specifications ?request()->specifications : [];
                $products = ShopProduct::whereIn('category_id' , $levelThree)->where('show' , 1)->orderByDesc('qty')->select('shop_products.*')
                ->when($input_specifications, function ($query) use ($input_specifications) {
                    $shop_poduct_values = ShopProductSpecification::whereIn('id', $input_specifications) 
                        ->distinct()->select('specification_id', 'value')->get();
                    $specifications = $shop_poduct_values->pluck('specification_id')->toArray();
                    $values = $shop_poduct_values->pluck('value')->toArray();
                    foreach ($specifications as $specification) {
                        $query->whereIn('id', ShopProductSpecification::where('specification_id', $specification)
                            ->whereIn('value', $values)->pluck('shop_product_id')->toArray());
                    }
                    return $query;
                })
                ->tap(function ($query) use (&$products_ids) {
                    $products_ids = array_unique($query->pluck('id')->toArray());
                })
                ->paginate(24)->appends(request()->except('page'));
                
                $specifications = $products_ids ?
                    new SpecificationsCollection(
                        Specification::whereIn(
                            'id',
                            ShopProductSpecification::whereIn('shop_product_id', $products_ids)
                                ->whereNotNull('value')->distinct()
                                ->pluck('specification_id')->toArray()
                        )->get()->where('weight' , '>' , 0)
                        ->sortByDesc('weight'),
                        $input_specifications,
                        $products_ids
                    ) : [];

                    $filter = [];
                   
                    
                    array_push($filter, ['type' => __('home.specifications'),
                        'key' => 'specifications',
                        'list' => $specifications]);
                        array_push($filter, [
                        'type' => __('Brands'),
                        'key' => 'brands',
                        'list' => BrandResource::collection(Brand::whereIn('id', $brandIds)->get())
                    ]);
                $results['category'] = new CategoryResource(Category::find($id)); 
                $results['sub_category'] = CategoryResource::collection(Category::where('parent' , $category->id)->where('show' ,1)->get());
                $results['products'] = ShopProductResource::collection($products);            
                $results['filter'] = $filter;
                $results['pagination'] = General::createPaginationArray($products);
                $results['from'] = $products->pluck('price')->min();
                $results['to'] = $products->pluck('price')->max();

            }elseif($category->level == 'level2')
            {
                $TwoAndThree = [];
                $levelThree  = $category->childs->pluck('id');
                $TwoAndThree = $levelThree->merge($category->id);                
                $brandIds =  BrandCategory::whereIn('category_id' , $TwoAndThree)->pluck('brand_id')->unique();
                $results['category_breadcrumbs'] = 
                [
                    'tiny_category' => null,/* CategoryResource::collection(Category::whereIn('parent' , $levelTwo)->get()), */
                    'subcategory'   => new CategoryNamesOnlyResource($category),
                    'category'      => new CategoryNamesOnlyResource(Category::find($category->parent)),
                    
                ];

                $results['brands'] = BrandResource::collection(Brand::whereIn('id' , $brandIds)->get());
                $products_ids=[] ;
                $input_specifications = request()->specifications ?request()->specifications : [];
                $products = ShopProduct::whereIn('category_id' , $levelThree)->where('show' , 1)->orderByDesc('qty')->select('shop_products.*')
                ->when($input_specifications, function ($query) use ($input_specifications) {
                    $shop_poduct_values = ShopProductSpecification::whereIn('id', $input_specifications) 
                        ->distinct()->select('specification_id', 'value')->get();
                    $specifications = $shop_poduct_values->pluck('specification_id')->toArray();
                    $values = $shop_poduct_values->pluck('value')->toArray();
                    foreach ($specifications as $specification) {
                        $query->whereIn('id', ShopProductSpecification::where('specification_id', $specification)
                            ->whereIn('value', $values)->pluck('shop_product_id')->toArray());
                    }
                    return $query;
                })
                ->tap(function ($query) use (&$products_ids) {
                    $products_ids = array_unique($query->pluck('id')->toArray());
                })
                ->paginate(24)->appends(request()->except('page'));
                
                $specifications = $products_ids ?
                    new SpecificationsCollection(
                        Specification::whereIn(
                            'id',
                            ShopProductSpecification::whereIn('shop_product_id', $products_ids)
                                ->whereNotNull('value')->distinct()
                                ->pluck('specification_id')->toArray()
                        )->get()
                        ->sortBy('weight', SORT_DESC),
                        $input_specifications,
                        $products_ids
                    ) : [];

                    $filter = [];
                   
                    
                    array_push($filter, ['type' => __('home.specifications'),
                        'key' => 'specifications',
                        'list' => $specifications]);
                $results['category'] = new CategoryResource(Category::find($id)); 
                $results['sub_category'] = CategoryResource::collection(Category::where('parent' , $category->id)->get());
                $results['products'] = ShopProductResource::collection($products);            
                $results['filter'] = $filter;
                $results['pagination'] = General::createPaginationArray($products);
                $results['from'] = $products->pluck('price')->min();
                $results['to'] = $products->pluck('price')->max();
            }else
            {
                $levelTwo   = Category::find($category->parent);
                $levelOne   = Category::find($levelTwo->parent);
                
                               
                $brandIds =  BrandCategory::where('category_id' , $category->id)->pluck('brand_id')->unique();
                 
                $results['category_breadcrumbs'] = 
                [
                    'tiny_category' => new CategoryResource($category),
                    'subcategory'   => $levelTwo,
                    'category'      => $levelOne,
                ];
                
                $results['brands'] = BrandResource::collection(Brand::whereIn('id' , $brandIds)->get());
                
                $products_ids=[] ;
                
                $input_specifications = request()->specifications ?request()->specifications : [];
                $products = ShopProduct::where('category_id' , $category->id)->where('show' , 1)->orderByDesc('qty')->select('shop_products.*')
                ->when($input_specifications, function ($query) use ($input_specifications) {
                    $shop_poduct_values = ShopProductSpecification::whereIn('id', $input_specifications) 
                        ->distinct()->select('specification_id', 'value')->get();
                    $specifications = $shop_poduct_values->pluck('specification_id')->toArray();
                    $values = $shop_poduct_values->pluck('value')->toArray();
                    foreach ($specifications as $specification) {
                        $query->whereIn('id', ShopProductSpecification::where('specification_id', $specification)
                            ->whereIn('value', $values)->pluck('shop_product_id')->toArray());
                    }
                    return $query;
                })
                ->tap(function ($query) use (&$products_ids) {
                    $products_ids = array_unique($query->pluck('id')->toArray());
                })
                ->paginate(24)->appends(request()->except('page'));
                
                $specifications = $products_ids ?
                    new SpecificationsCollection(
                        Specification::whereIn(
                            'id',
                            ShopProductSpecification::whereIn('shop_product_id', $products_ids)
                                ->whereNotNull('value')->distinct()
                                ->pluck('specification_id')->toArray()
                        )->get()
                        ->sortBy('weight', SORT_DESC),
                        $input_specifications,
                        $products_ids
                    ) : [];

                    $filter = [];
                   
                    
                    array_push($filter, ['type' => __('home.specifications'),
                        'key' => 'specifications',
                        'list' => $specifications]);
                       
                $results['category'] = new CategoryResource(Category::find($id));       
                $results['sub_category'] = CategoryResource::collection(Category::where('parent' , $category->id)->get());
                $results['products'] = ShopProductResource::collection($products);            
                $results['filter'] = $filter;
                $results['pagination'] = General::createPaginationArray($products);
                $results['from'] = $products->pluck('price')->min();
                $results['to'] = $products->pluck('price')->max();
                
            }
            
            return $this->result = ['validator' => null, 'success' => 'category Details','errors'=>null,'object'=>$results];
        }catch (\Exception $exception) {
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }

    private function breadcrumbs($category)
    {
        $categories = [];
        $this->getParentCategory($category, $categories);
        return $categories;
    }

    private function getParentCategory($category, &$categories)
    {
        if (is_null($category->parent)) {
            $categories['category'] = ['id' => $category->id, 'name' => $category->name];

            return $category->name;
        }

        if (count($categories) == 0) {
            $categories['tiny_category'] = ['id' => $category->id, 'name' => $category->name];
        } else {
            $categories['sub_category'] = ['id' => $category->id, 'name' => $category->name];
        }

        $parent = Category::where('id', $category->parent)->first();

        return $this->getParentCategory($parent, $categories);
    }
    
    public function categoryChilds($id)
    {
        $category = Category::with('childs')->find($id);
        switch($category->level)
        {
            case 'level1':
                $categoryLevelTwo = Category::where('parent' , '=' , $category->id)->where('show' , 1)->pluck('id');
                $categoryLevelThree = Category::whereIn('parent' ,  $categoryLevelTwo)->where('show' , 1)->get();
                return $categoryLevelThree;
                break;
            case 'level2':
                return Category::where('parent' , '=' , $category->id)->where('show', 1)->get();
                break;
            case 'level3':
                return $category;
                break;
            default:
                return 'SomeThing Went Wrong';
                break;
        }
    }
    
    public function recentlyArrived($id)
    {	
        $levelThreeCategories = $this->categoryChilds($id);
      	$levelThreeIds  = [];
        foreach( $levelThreeCategories  as $levelThree)
        {
            $levelThreeIds [] = $levelThree->id;
        }
        $levelThreeIds = array_unique($levelThreeIds);

        $allShopProductsArray = ShopProductResource::collection(
            ShopProduct::whereIn('category_id', $levelThreeIds)->where('show' , 1)->where('qty' , '>' , 0)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get());      
        return $this->result = ['validator' => null, 'success' => 'Recently Added Products','errors'=>null,'object'=>$allShopProductsArray];

    }
    
    public function bestSeller($id)
    {
        $levelThreeIds = $this->categoryChilds($id)->pluck('id')->unique();

        $shopProductIds = ShopProduct::whereIn('category_id', $levelThreeIds)->pluck('id');

        // Step 3: Get the best-seller products within these shop_product_ids
        $bestSellers = DB::table('cart_items')
            ->select('shop_product_id', DB::raw('count(*) as total'))
            ->whereIn('shop_product_id', $shopProductIds)
            ->groupBy('shop_product_id')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
    
        // Step 4: Get detailed information for the best-selling products
        $bestSellersProductIds = $bestSellers->pluck('shop_product_id');
        $bestSellersWithDetails = ShopProductResource::collection(ShopProduct::whereIn('id', $bestSellersProductIds)->where('show' , 1)->get());

        if($bestSellersWithDetails->count() < 10)
        {
            $remainingCount = 10 - $bestSellersWithDetails->count();
            $recentlyArrivedProducts = $this->recentlyArrived($id)['object']->take($remainingCount);
            
            // Merge the best sellers with the recently arrived products
            $bestSellersWithDetails = $bestSellersWithDetails->merge($recentlyArrivedProducts);
        }
        return $this->result = ['validator' => null, 'success' => 'Recently Added Products','errors'=>null,'object'=>$bestSellersWithDetails];
    }
    
    public function categoryBrands($id)
    {
        $category = Category::with('childs')->find($id);
        if($category->level !== 'level3')
        {
        $levelThreeIds = $this->categoryChilds($id)->pluck('id')->unique();
        }else{
        $levelThreeIds []= $category->id;
        }
        // Fetch all products within the level-three categories
        $productBrandIds = ShopProduct::whereIn('category_id', $levelThreeIds)
                                       ->pluck('brand_id')
                                       ->unique();


        $brands = BrandResource::collection(Brand::whereIn('id', $productBrandIds)->where('show' , 1)->get());
        return $this->result = ['validator' => null, 'success' => 'Category brands','errors'=>null,'brands'=>$brands];
    }
    
    public function categoryLevelOne($id)
    {
        try{
            $category = Category::with('childs')->where('id', $id)->first();
            
            if($category->level == 'level1')
            {
                $levelTwo   = $category->childs->pluck('id');
                $levelThree = Category::whereIn('parent' , $levelTwo)->where('show' , 1)->pluck('id');
                    
                 
                $results['category_breadcrumbs'] = 
                [
                    'tiny_category' => null,
                    'subcategory'   => null,
                    'category'      => new CategoryResource($category),
                ];

                $products = ShopProduct::whereIn('category_id' , $levelThree)->where('show' , 1)->inRandomOrder()->take(10)->where('qty' , '>' , 0)->get();
                $main_banner = CategoryBanner::where('category_id' , '=' , $id)->where('section' , '=' , '1')->first();
                $ads_one = CategoryBanner::where('category_id' , '=' , $id)->where('section' , '=' , '2')->first();
                $ads_two = CategoryBanner::where('category_id' , '=' , $id)->where('section' , '=' , '3')->first();
                $ads_three = CategoryBanner::where('category_id' , '=' , $id)->where('section' , '=' , '4')->first();
                
                $results['category'] = new CategoryResource(Category::find($id)); 
                $results['main_banner'] =  $main_banner == null ? null : new CategoryBannerResource($main_banner);
                $results['ads_one'] = $ads_one == null ? null : new CategoryBannerResource($ads_one);
                $results['ads_two'] = $ads_two == null ? null : new CategoryBannerResource($ads_two);
                $results['ads_three'] = $ads_three == null ? null : new CategoryBannerResource($ads_three);
                $results['sub_category'] = CategoryResource::collection(Category::where('parent' , $category->id)->where('show' ,1)->get());
                $results['productsForYou'] = ShopProductResource::collection($products);            

            }
            return $this->result = ['validator' => null, 'success' => 'category Details','errors'=>null,'object'=>$results];
        }catch (\Exception $exception) {
            dd($exception);
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }
    
    public function categoryLevelTwo($id)
    {
        try{
            $category = Category::with('childs')->where('id', $id)->first();
            
            if($category->level == 'level2')
            {
                $levelThree = $this->categoryChilds($id)->pluck('id')->unique();

                // $levelThree   = $category->childs->pluck('id');

                 
                 $results['category_breadcrumbs'] = 
                [
                    'tiny_category' => null,/* CategoryResource::collection(Category::whereIn('parent' , $levelTwo)->get()), */
                    'subcategory'   => new CategoryNamesOnlyResource($category),
                    'category'      => new CategoryNamesOnlyResource(Category::find($category->parent)),
                    
                ];

                $products = ShopProduct::whereIn('category_id' , $levelThree)->where('show' , 1)->inRandomOrder()->where('qty' , '>' , 0)->take(10)->get();
                $main_banner = CategoryBanner::where('category_id' , '=' , $id)->where('section' , '=' , '1')->first();
                $ads_one = CategoryBanner::where('category_id' , '=' , $id)->where('section' , '=' , '2')->first();
                $ads_two = CategoryBanner::where('category_id' , '=' , $id)->where('section' , '=' , '3')->first();
                $ads_three = CategoryBanner::where('category_id' , '=' , $id)->where('section' , '=' , '4')->first();

                $results['category'] = new CategoryResource(Category::find($id)); 
                $results['main_banner'] =  $main_banner == null ? null : new CategoryBannerResource($main_banner);
                $results['ads_one'] = $ads_one == null ? null : new CategoryBannerResource($ads_one);
                $results['ads_two'] = $ads_two == null ? null : new CategoryBannerResource($ads_two);
                $results['ads_three'] = $ads_three == null ? null : new CategoryBannerResource($ads_three);
                $results['sub_category'] = CategoryResource::collection(Category::where('parent' , $category->id)->where('show' ,1)->get());
                $results['productsForYou'] = ShopProductResource::collection($products);            

            }
            return $this->result = ['validator' => null, 'success' => 'category Details','errors'=>null,'object'=>$results];
        }catch (\Exception $exception) {
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }
    
    public function categoryOffers($id)
    {
        try{
        $levelThreeCategories = $this->categoryChilds($id);
        foreach( $levelThreeCategories  as $levelThree)
        {
            $levelThreeIds [] = $levelThree->id;
        }
        $levelThreeIds = array_unique($levelThreeIds);


        $allShopProductsArray = ShopProductResource::collection(
            ShopProduct::whereIn('category_id', $levelThreeIds)
                ->where('show', 1)
                ->where('qty', '>', 0)
                ->where('offer', 1)
                ->paginate(10)
                ->appends(request()->except('page')) // Correct closing parenthesis
        );     
        $results['products'] = $allShopProductsArray;
        $results['pagination'] = General::createPaginationArray($allShopProductsArray);
        return $this->result = ['validator' => null, 'success' => 'Offer Product','errors'=>null,'object'=>$results];
        }catch (\Exception $exception) {
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }

    public function offerBanner()
    {
        $results['main_banner'] = new BundelBannerResource(Banner::where('section' , '=' , 10)->first());
        $categoriesLOne = Category::where('level','level1')->get();
        $resultCategory = [];
        foreach($categoriesLOne as $category)
        {
        	$levelThreeCategories = $this->categoryChilds($category->id)->pluck('id');
            $offerProductCount = ShopProduct::where('offer' , 1)->where('qty', '>', 0)->where('show', 1)->whereIn('category_id' , $levelThreeCategories)->count();
          
            if($offerProductCount>0)
            {
                $resultCategory [] = $category;
            }
        }

        $results ['categories'] = CategoryResource::collection($resultCategory);
        return $this->result = ['validator' => null, 'success' => 'Offer Brands', 'errors' => null, 'object' => $results];
    }
  
    public function categorySeo($id)
    {
      	$category = Category::find($id);
        $results['seo'] = new CategorySeoResource($category);
        return $this->result = ['validator' => null, 'success' => 'Category Seo', 'errors' => null, 'object' => $results];
    }
  
    public function offerSeo()
    {
      	$offerSeo = Seo::where('page_name' , 'offers')->first();
        $results['seo'] = new PageSeoResource($offerSeo);
        return $this->result = ['validator' => null, 'success' => 'Offers Page Seo', 'errors' => null, 'object' => $results];
    }
    
    public function categoryLevelThree($id)
    {
            $category = Category::with('childs')->where('id', $id)->first();
            if (!$category) {
                return response()->json(['error' => 'Category not found.'], 404);
            }
    
            $levelTwo = Category::find($category->parent);
            $levelOne = Category::find($levelTwo->parent ?? null);
    
            $results['category_breadcrumbs'] = [
                'tiny_category' => new CategoryResource($category),
                'subcategory'   => new CategoryResource($levelTwo),
                'category'      => new CategoryResource($levelOne),
            ];
    
            $input_specifications = request()->input('specification', []);
            $input_brands = request()->input('brand', []);
            $min_price = request()->input('min_price', null);
            $max_price = request()->input('max_price', null);
            $search = request()->input('search', null);
            $sort_by = request()->input('Options', 'qty'); 
            $sort_order = request()->input('sort_order', 'desc'); 
    
            $main_banner = Cache::remember("main_banner_{$id}", now()->addMinutes(30), function () use ($id) {
                return CategoryBanner::where('category_id', $id)->where('section', '1')->first();
            });
    
            $allProductIds = Cache::remember("all_product_ids_{$id}", now()->addMinutes(30), function () use ($category) {
                return ShopProduct::where('category_id', $category->id)
                    ->where('show', 1)
                    ->pluck('id')
                    ->toArray();
            });
    
            if (empty($allProductIds)) {
                return response()->json(['error' => 'No products found in this category.']);
            }
    
            $products = ShopProduct::where('category_id', $category->id)
                ->where('shop_products.show', 1)
                ->select('shop_products.*')
                ->leftJoin('shop_product_translations', 'shop_products.id', '=', 'shop_product_translations.shop_product_id')
                ->leftJoin('brands', 'shop_products.brand_id', '=', 'brands.id')
                ->leftJoin('brand_translations', 'brands.id', '=', 'brand_translations.brand_id')
                ->distinct('shop_products.id')
                ->when($input_specifications, function ($query) use ($input_specifications) {
                    $specifications = ShopProductSpecification::whereIn('id', $input_specifications)
                        ->pluck('specification_id')->toArray();
                    return $query->whereIn('shop_products.id', ShopProductSpecification::whereIn('specification_id', $specifications)
                        ->pluck('shop_product_id')->toArray());
                })
                ->when($input_brands, function ($query) use ($input_brands) {
                    return $query->whereIn('shop_products.brand_id', $input_brands);
                })
                ->when($min_price, function ($query) use ($min_price) {
                    return $query->where('new_price', '>=', $min_price);
                })
                ->when($max_price, function ($query) use ($max_price) {
                    return $query->where('new_price', '<=', $max_price);
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where(function ($query) use ($search) {
                        $query->where('shop_product_translations.name', 'LIKE', "%{$search}%")
                              ->orWhere('shop_products.sku_code', 'LIKE', "%{$search}%")
                              ->orWhere('brand_translations.name', 'LIKE', "%{$search}%");
                    });
                })
                ->when($sort_by, function ($query) use ($sort_by, $sort_order) {
                    return $query->orderBy($sort_by, $sort_order);
                })
                ->paginate(24)
                ->appends(request()->except('page'));
    
            $filter = Cache::remember("filter_{$id}", now()->addMinutes(30), function () use ($allProductIds) {
                $specifications = Specification::whereIn(
                    'id',
                    ShopProductSpecification::whereIn('shop_product_id', $allProductIds)
                        ->whereNotNull('value')
                        ->distinct()
                        ->pluck('specification_id')
                        ->toArray()
                )->get()->sortBy('weight', SORT_DESC);
    
                $allSpecifications = $specifications->map(function ($spec) use ($allProductIds) {
                    return [
                        'id'                 => $spec->id,
                        'specification'      => $spec->name,
                        'shop_product_values'=> ShopProductSpecification::where('specification_id', $spec->id)
                            ->whereIn('shop_product_id', $allProductIds)
                            ->distinct()
                            ->get()
                            ->map(fn($spv) => [
                                'id'           => $spv->id,
                                'selected'     => 0,
                                'specification'=> $spec->name,
                                'value'        => $spv->value,
                            ])
                            ->unique('value')
                            ->values()
                            ->toArray(),
                    ];
                })->values()->toArray();
    
                $brandIds = ShopProduct::whereIn('id', $allProductIds)->pluck('brand_id')->unique();
                $brands = Brand::whereIn('id', $brandIds)->get();
    
                return [
                    [
                        'type' => __('home.specifications'),
                        'key'  => 'specifications',
                        'list' => $allSpecifications
                    ],
                    [
                        'type' => __('home.brands'),
                        'key'  => 'brands',
                        'list' => BrandResource::collection($brands)
                    ],
                    [
                        'type' => __('home.price'),
                        'key'  => 'price',
                        'min_price' => ShopProduct::whereIn('id', $allProductIds)->min('new_price'),
                        'max_price' => ShopProduct::whereIn('id', $allProductIds)->max('new_price'),
                    ]
                ];
            });
    
            $results['main_banner'] = $main_banner ? new CategoryBannerResource($main_banner) : null;
            $results['products'] = ShopProductResource::collection($products);
            $results['filter'] = $filter;
            $results['pagination'] = General::createPaginationArray($products);
    
            return [
                'validator' => null,
                'success' => 'Category Details',
                'errors' => null,
                'object' => $results
            ];
    }

    public function categoryLevelThreefilter($id)
    {
        $category = Category::with('childs')->where('id', $id)->first();
        $levelTwo = Category::find($category->parent);
        $levelOne = Category::find($levelTwo->parent);
    
        $brandIds = BrandCategory::where('category_id', $category->id)->pluck('brand_id')->unique();
    
        $results['category_breadcrumbs'] = [
            'tiny_category' => new CategoryResource($category),
            'subcategory'   => $levelTwo,
            'category'      => $levelOne,
        ];
    
        $input_specifications = request()->input('specification', []); // Default to empty array if not provided
        $input_brands = request()->input('brand', []);
        $min_price = request()->input('min_price', null);
        $max_price = request()->input('max_price', null);
        $search = request()->input('search', null);
        $sort_by = request()->input('sort_by', 'qty'); // Default sort by 'qty'
        $sort_order = request()->input('sort_order', 'desc'); // Default sort order 'desc'
        $main_banner = CategoryBanner::where('category_id', $id)->where('section', '1')->first();
        
        // Step 1: Get all product IDs in the category (before filtering)
        $allProductIds = ShopProduct::where('category_id', $category->id)
            ->where('show', 1)
            ->pluck('id')
            ->toArray();
        
        // Check how many products are in the category before filtering
        $productCountBeforeFilters = count($allProductIds);
        if ($productCountBeforeFilters === 0) {
            return response()->json(['error' => 'No products found in this category before filtering.']);
        }
        
        $products = ShopProduct::where('category_id', $category->id)
            ->where('show', 1)
            ->select('shop_products.*')
            ->leftJoin('shop_product_translations', 'shop_products.id', '=', 'shop_product_translations.shop_product_id')
            ->when($input_specifications, function ($query) use ($input_specifications) {
                $shop_poduct_values = ShopProductSpecification::whereIn('id', $input_specifications)
                    ->distinct()
                    ->select('specification_id', 'value')
                    ->get();
        
                $specifications = $shop_poduct_values->pluck('specification_id')->toArray();
                $values = $shop_poduct_values->pluck('value')->toArray();
        
                foreach ($specifications as $specification) {
                    $query->whereIn('shop_products.id', ShopProductSpecification::where('specification_id', $specification)
                        ->whereIn('value', $values)
                        ->pluck('shop_product_id')
                        ->toArray());
                }
                return $query;
            })
            ->when($input_brands, function ($query) use ($input_brands) {
                return $query->whereIn('brand_id', $input_brands);
            })
            ->when($min_price, function ($query) use ($min_price) {
                return $query->where('new_price', '>=', $min_price);
            })
            ->when($max_price, function ($query) use ($max_price) {
                return $query->where('new_price', '<=', $max_price);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('shop_product_translations.name', 'LIKE', "%{$search}%")
                          ->orWhere('shop_product_translations.name', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%")
                          ->orWhere('shop_product_translations.description', 'LIKE', "%{$search}%")
                          ->orWhere('shop_product_translations.description', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%");
                });
            })
            ->when($sort_by, function ($query) use ($sort_by, $sort_order) {
                return $query->orderBy($sort_by, $sort_order);
            })
            ->tap(function ($query) use (&$products_ids) {
                $products_ids = array_unique($query->pluck('shop_products.id')->toArray());
            })
            ->paginate(24)
            ->appends(request()->except('page'));

    
        // Check if products are empty after filtering
        if ($products->isEmpty()) {
            return response()->json(['error' => 'No products found after applying filters.']);
        }
    
        // Prepare filters for response
        $filter = [];
    
        // Retrieve all specifications and their values for the category (before filtering)
        $specifications = Specification::whereIn(
            'id',
            ShopProductSpecification::whereIn('shop_product_id', $allProductIds)
                ->whereNotNull('value')
                ->distinct()
                ->pluck('specification_id')
                ->toArray()
        )->get()->sortBy('weight', SORT_DESC);
    
        $allSpecifications = $specifications->map(function ($spec) use ($allProductIds) {
            $shopProductValues = ShopProductSpecification::where('specification_id', $spec->id)
                ->whereIn('shop_product_id', $allProductIds)
                ->get();
    
            $formattedValues = $shopProductValues->map(function ($spv) use ($spec) {
                return [
                    'id'           => $spv->id,
                    'selected'     => 0,
                    'specification'=> $spec->name,
                    'value'        => $spv->value,
                ];
            })->unique('value')->values()->toArray();
    
            return [
                'id'                 => $spec->id,
                'specification'      => $spec->name,
                'shop_product_values'=> $formattedValues,
            ];
        })->values()->toArray();
    
        array_push($filter, [
            'type' => __('home.specifications'),
            'key'  => 'specifications',
            'list' => $allSpecifications
        ]);
    
        // Retrieve and prepare brand filters
        $brands = Brand::whereIn('id', $brandIds)->get();
        array_push($filter, [
            'type' => __('home.brands'),
            'key'  => 'brands',
            'list' => BrandResource::collection($brands)
        ]);
    
        // Add price filter
        array_push($filter, [
            'type' => __('home.price'),
            'key'  => 'price',
            'min_price' => $products->pluck('new_price')->min(),
            'max_price' => $products->pluck('new_price')->max(),
        ]);
    
        $results['filter'] = $filter;
        return $this->result = ['validator' => null, 'success' => 'Category Details', 'errors' => null, 'object' => $results];
    }
    
    public function categoryLevelThreeProductsCount($id)
    {
        $category = Category::with('childs')->where('id', $id)->first();
        $levelTwo = Category::find($category->parent);
        $levelOne = Category::find($levelTwo->parent);
    
        $brandIds = BrandCategory::where('category_id', $category->id)->pluck('brand_id')->unique();
    
        $input_specifications = request()->input('specification', []); // Default to empty array if not provided
        $input_brands = request()->input('brand', []);
        $min_price = request()->input('min_price', null);
        $max_price = request()->input('max_price', null);
        $search = request()->input('search', null);
        $sort_by = request()->input('Options', null); // Default sort by 'qty'
        $sort_order = request()->input('sort_order', 'desc'); // Default sort order 'desc'
        $main_banner = CategoryBanner::where('category_id', $id)->where('section', '1')->first();
        
        // Step 1: Get all product IDs in the category (before filtering)
        $allProductIds = ShopProduct::where('category_id', $category->id)
            ->where('show', 1)
            ->pluck('id')
            ->toArray();
        
        // Check how many products are in the category before filtering
        $productCountBeforeFilters = count($allProductIds);
        if ($productCountBeforeFilters === 0) {
            return response()->json(['error' => 'No products found in this category before filtering.']);
        }
               
        $products = ShopProduct::where('category_id', $category->id)
            ->where('shop_products.show', 1)
            ->select('shop_products.*')
            ->orderBy('shop_products.qty', 'desc')
            ->leftJoin('shop_product_translations', 'shop_products.id', '=', 'shop_product_translations.shop_product_id')
            ->leftJoin('brands', 'shop_products.brand_id', '=', 'brands.id')
            ->leftJoin('brand_translations', 'brands.id', '=', 'brand_translations.brand_id')
            ->distinct('shop_products.id')
            ->when($input_specifications, function ($query) use ($input_specifications) {
                $shop_poduct_values = ShopProductSpecification::whereIn('id', $input_specifications)
                    ->distinct()
                    ->select('specification_id', 'value')
                    ->get();
        
                $specifications = $shop_poduct_values->pluck('specification_id')->toArray();
                $values = $shop_poduct_values->pluck('value')->toArray();
        
                foreach ($specifications as $specification) {
                    $query->whereIn('shop_products.id', ShopProductSpecification::where('specification_id', $specification)
                        ->whereIn('value', $values)
                        ->pluck('shop_product_id')
                        ->toArray());
                }
                return $query;
            })
            ->when($input_brands, function ($query) use ($input_brands) {
                return $query->whereIn('brand_id', $input_brands);
            })
            ->when($min_price, function ($query) use ($min_price) {
                return $query->where('new_price', '>=', $min_price);
            })
            ->when($max_price, function ($query) use ($max_price) {
                return $query->where('new_price', '<=', $max_price);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('shop_product_translations.name', 'LIKE', "%{$search}%")
                          ->orWhere('shop_product_translations.name', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%")
                          ->orWhere('shop_product_translations.description', 'LIKE', "%{$search}%")
                          ->orWhere('shop_product_translations.description', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%")
                          ->orWhere('shop_products.sku_code', 'LIKE',"%{$search}%")
                          ->orWhere('brand_translations.name', 'LIKE', "%{$search}%")
                          ->orWhere('brand_translations.name', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%");
                });
            })
            ->when($sort_by, function ($query) use ($sort_by, $sort_order) {
                switch ($sort_by) {
                    case 'latest':
                        // Sort by creation date, descending
                        return $query->orderBy('shop_products.created_at', 'desc');
                    case 'highest price':
                        // Sort by new price, descending
                        return $query->orderBy('shop_products.new_price', 'desc');
                    case 'lowest price':
                        // Sort by new price, ascending
                        return $query->orderBy('shop_products.new_price', 'asc');
                    default:
                        // Default sorting logic (if any other field is passed)
                        return $query->orderBy($sort_by, $sort_order);
                }
            })
            ->tap(function ($query) use (&$products_ids) {
                $products_ids = array_unique($query->pluck('shop_products.id')->toArray());
            })
            ->paginate(25)
            ->appends(request()->except('page'));


        // Check if products are empty after filtering
        // if ($products->isEmpty()) {
        //     return response()->json(['error' => 'No products found after applying filters.']);
        // }
    
        // Prepare filters for response
        $filter = [];
    
        // Retrieve all specifications and their values for the category (before filtering)
        $specifications = Specification::whereIn(
            'id',
            ShopProductSpecification::whereIn('shop_product_id', $allProductIds)
                ->whereNotNull('value')
                ->distinct()
                ->pluck('specification_id')
                ->toArray()
        )->get()->sortBy('weight', SORT_DESC);
     
        $allSpecifications = $specifications->map(function ($spec) use ($allProductIds) {
            $shopProductValues = ShopProductSpecification::where('specification_id', $spec->id)
                ->whereIn('shop_product_id', $allProductIds)
                ->get();
   
            $formattedValues = $shopProductValues->map(function ($spv) use ($spec) {
                return [
                    'id'           => $spv->id,
                    'selected'     => 0,
                    'specification'=> $spec->name,
                    'value'        => $spv->value,
                ];
            })->unique('value')->values()->toArray();
    
            return [
                'id'                 => $spec->id,
                'specification'      => $spec->name,
                'shop_product_values'=> $formattedValues,
            ];
        })->values()->toArray();
    
        array_push($filter, [
            'type' => __('home.specifications'),
            'key'  => 'specifications',
            'list' => $allSpecifications
        ]);
    
        // Retrieve and prepare brand filters
        $brands = Brand::whereIn('id', $brandIds)->get();
        array_push($filter, [
            'type' => __('home.brands'),
            'key'  => 'brands',
            'list' => BrandResource::collection($brands)
        ]);
    
        // Add price filter
        array_push($filter, [
            'type' => __('home.price'),
            'key'  => 'price',
            'min_price' => $products->pluck('new_price')->min(),
            'max_price' => $products->pluck('new_price')->max(),
        ]);
        $results['products_count'] = $products->total(); // Total count of filtered products
        return $this->result = ['validator' => null, 'success' => 'Category Details', 'errors' => null, 'object' => $results];
    }
}
