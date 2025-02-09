<?php

namespace App\Repository\User;

use App\Http\Resources\AdsBannerResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryNameImageOnlyResource;
use App\Http\Resources\CategoryNamesOnlyResource;
use App\Http\Resources\Collections\BannersCollection;
use App\Http\Resources\Collections\BlogsCollection;
use App\Http\Resources\Collections\BrandsCollection;
use App\Http\Resources\Collections\CategoriesCollection;
use App\Http\Resources\Collections\CitiesCollection;
use App\Http\Resources\Collections\CompaniesCollection;
use App\Http\Resources\Collections\ShopProductsForHomeCollection;
use App\Http\Resources\PolicyResource;
use App\Http\Resources\RefundAndReturnsPolicyResource;
use App\Http\Resources\ShopProductRecentlyViewedResource;
use App\Http\Resources\TermsResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\HomeSeoResource;
use App\Mail\GetListedMail;
use App\Models\AdBanner;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\CompanyRequest;
use App\Models\OrderItem;
use App\Models\PrivacyPolicy;
use App\Models\Product;
use App\Models\RefundAndReturnsPolicy;
use App\Models\SellPolicy;
use App\Models\ShopProduct;
use App\Models\Term;
use App\Models\UserShopProductsView;
use App\Models\BrandTranslation;
use App\Models\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Specification;
use App\Models\ShopProductSpecification;
use App\Http\Resources\BrandResource;
use App\Http\Resources\ShopProductResource;
use App\Helpers\General;

class HomeRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }

    public function home()
    {
        DB::beginTransaction();
        try {
            $results['ads_banners'] = $this->adBanners()['success'] ? $this->adBanners()['object']['ad_banners'] : [];
            $results['banners'] = $this->banners()['success'] ? $this->banners()['object']['banners'] : [];
            $results['gridCategories'] = $this->featuredCategories()['success'] ? $this->featuredCategories()['object']['categories'] : [];
            $results['TrendingCompanies'] = $this->featuredCompanies()['success'] ? $this->featuredCompanies()['object']['companies'] : [];
            $results['TrendingBrands'] = $this->featuredBrands()['success'] ? $this->featuredBrands()['object']['brands'] : [];
            $results['productCount'] = Product::count();
            $results['companyCount'] = Company::count();
            $results['brandCount'] = Brand::count();
            $results['categoryCount'] = Category::count();
            return $this->result = ['validator' => null, 'success' => 'success', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function banners()
    {
        DB::beginTransaction();
        try {
            $results['banners'] = 
            [
                'SliderBanners' => new BannersCollection(Banner::where('section' , '=' , 1)->get()),
                'SectionOne' => new BannersCollection(Banner::where('section' , '=' , 2)->get()),
                'SectionTwo' => new BannersCollection(Banner::where('section' , '=' , 3)->get()),
                'sectionThree' => new BannersCollection(Banner::where('section' , '=' , 4)->get()),
            ];
            //new BannersCollection(Banner::where('section' , '=' , 1)->get());
            return $this->result = ['validator' => null, 'success' => 'Banners', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function adBanners()
    {
        DB::beginTransaction();
        try {
            $results['ad_banners'] = new AdsBannerResource(AdBanner::first());
            return $this->result = [
                'validator' => null,
                'success' => 'Ads Banners', 'errors' => null, 'object' => $results
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function recentlyViewed()
    {
        DB::beginTransaction();
        try {
            $user = auth('api')->user();

            if ($user) {
                $recently_viewed_shop_products_ids =
                    UserShopProductsView::where('user_id', $user->id)
                    ->whereDate(
                        'created_at',
                        '>',
                        config(
                            'global.recently_viewed_products_after_timestamp',
                            date('Y-m-d', strtotime("-1 days"))
                        )
                    )
                    ->pluck('shop_product_id')->toArray();
            } else {
                $recently_viewed_shop_products_ids =
                    UserShopProductsView::where('ip', request()->ip())
                    ->whereDate(
                        'created_at',
                        '>',
                        config(
                            'global.recently_viewed_products_after_timestamp',
                            date('Y-m-d', strtotime("-1 days"))
                        )
                    )
                    ->pluck('shop_product_id')->toArray();
            }

            $recently_viewed_shop_products = ShopProduct::whereIn('id', $recently_viewed_shop_products_ids)
                ->select('id', 'image', 'new_price', 'old_price', 'mobileimg')
                ->with(['translations' => function ($query) {
                    $query->select('id', 'shop_product_id', 'name', 'locale');
                }])
                ->get();

            $results['recentlyViewed'] =
                ShopProductRecentlyViewedResource::collection($recently_viewed_shop_products);

            return $this->result =
                [
                    'validator' => null,
                    'success' => 'Recently Viewed Products',
                    'errors' => null, 'object' => $results
                ];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = [
                'validator' => null,
                'success' => null, 'errors' => $exception, 'object' => null
            ];
        }
    }

    public function featuredCategories()
    {
        DB::beginTransaction();
        try {
            $results['categories'] = new CategoriesCollection(Category::where('featured', 1)->where('level', 'level1')->get());
            return $this->result = ['validator' => null, 'success' => 'Featured Categoreis', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function shownCategories()
    {
        DB::beginTransaction();
        try {
            $results['shownCategories'] =  CategoryNameImageOnlyResource::collection(Category::where('show', 1)->where('level', 'level1')->get());
            //   dd( $results['shownCategories']);
            return $this->result = ['validator' => null, 'success' => 'shown Categoreis', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function featuredBrands()
    {
        DB::beginTransaction();
        try {
            $results['brands'] = new BrandsCollection(Brand::where('featured', 1)->get());
            return $this->result = ['validator' => null, 'success' => 'Featured Brands', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function featuredCompanies()
    {
        DB::beginTransaction();
        try {
            $results['companies'] = new CompaniesCollection(Company::where('hidden', 1)->where('feature', 1)->get());
            return $this->result = ['validator' => null, 'success' => 'Featured Companies', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function blogs()
    {
        try {
            $results['blogs'] = new BlogsCollection(Blog::orderBy('created_at', 'desc')->paginate(4));
            return $this->result = ['validator' => null, 'success' => 'success', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function blog($id)
    {
        $result['blog'] = null;
        try {
            $blog = Blog::find($id);
            if ($blog) {
                $results['blog'] = new BlogResource($blog);
                return $this->result = ['validator' => null, 'success' => 'success', 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => 'Blog not found', 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function sellPolicies()
    {
        try {
            $policy = SellPolicy::first();
            if ($policy) {
                $results['policy'] = new PolicyResource($policy);
                return $this->result = ['validator' => null, 'success' => 'success', 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => 'Policy not found', 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function PrivacyPolicy()
    {
        try {
            $privacy = PrivacyPolicy::first();
            if ($privacy) {
                $results['privacy'] = new PolicyResource($privacy);
                return $this->result = ['validator' => null, 'success' => 'Privacy and Policy', 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => 'Privacy & Policy not found', 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function termsConditions()
    {
        $result['terms'] = null;
        try {
            $terms = Term::first();
            if ($terms) {
                $results['terms'] = new TermsResource($terms);
                return $this->result = ['validator' => null, 'success' => 'success', 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => 'Terms Not found', 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function refundAndReturnsPolicy()
    {
        $result['refundAndReturnsPolicy'] = null;

        try {
            $refundAndReturnsPolicy = RefundAndReturnsPolicy::first();
            if ($refundAndReturnsPolicy) {
                $results['refundAndReturnsPolicy'] = new RefundAndReturnsPolicyResource($refundAndReturnsPolicy);
                return $this->result = ['validator' => null, 'success' => 'success', 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => 'Terms Not found', 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    /**
     * Store Companies requests in DB..
     *
     * @return array()
     */
    public function storeCompanyRequest()
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            $company = CompanyRequest::create([
                'name' => $request->input('name'),
                'company_name' => $request->input('company_name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'phone' => $request->input('phone'),
                'company_type' => $request->input('company_type'),
                'website' => $request->input('website'),
                'facebook' => $request->input('facebook'),
            ]);
            DB::commit();
            Mail::to($company->email)->send(new GetListedMail($company->company_name));
            return $this->result = ['validator' => null, 'success' => __('home.companyRequestMessage'), 'errors' => null, 'object' => $company];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function listAllCountries()
    {
        $results['countries'] = new CitiesCollection(City::all());
        return $this->result = ['validator' => null, 'success' => 'List Cities', 'errors' => null, 'object' => $results];
    }

    public function bestSellerProducts($request)
    {
        try {
            $user = User::getUser($request);
            $top_ten_soled_products = ShopProduct::whereIn('id', OrderItem::select(['shop_product_id', DB::raw('count(*) as count')])->groupBy('shop_product_id')->orderBy('count', 'DESC')->take(10)->pluck('shop_product_id'))->get();
            $results['bestSellerProducts'] =
                new ShopProductsForHomeCollection($top_ten_soled_products, $user);
            return $this->result = ['validator' => null, 'success' => 'Best Seller Shop Products', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function arrivedRecently()
    {
        try {
            $user = auth('api')->user();
            $recently_arrived = ShopProduct::orderBy('created_at', 'desc')->where('qty' , '>' , 0)
            ->take(10)
            ->get();
            $results['recently_arrived'] =
                new ShopProductsForHomeCollection($recently_arrived , $user);
            return $this->result = ['validator' => null, 'success' => 'Recently Added Shop Products', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function featuredShopProducts()
    {
        try {
            $user = auth('api')->user();
            $results['featuredShopProducts'] =
                new ShopProductsForHomeCollection(
                    ShopProduct::where('featured', 1)->get(),
                    $user
                );
            return $this->result = ['validator' => null, 'success' => 'Featured Shop Products', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function featuredShopCategories()
    {
        try {
            $categories = Category::where('level', 'level1')
                ->featured()
                ->select('level', 'id', 'parent')
                ->with(['translations' => function ($query) {
                    $query->select('id', 'category_id', 'name', 'locale');
                }])
                ->with(['childs' => function ($query) {
                    $query->select('id')->with(['translations' => function ($query) {
                        $query->select('id', 'category_id', 'name', 'locale');
                    }]);
                }])
                ->get();

            $results['featuredShopCategories'] = CategoryNamesOnlyResource::collection($categories);
            // new CategoriesCollection($categories, [], 'shop');
            return $this->result = [
                'validator' => null,
                'success' => 'All Shop Categories',
                'errors' => null, 'object' => $results
            ];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    // return level 1 categories and all the featured products under them
    public function categoriesProducts($request)
    {
        try {
            $user = User::getUser($request);

            $level_1_categories = Category::where('level', 'level1')
                ->select('id', 'level', 'parent', 'image')
                ->with(['translations' => function ($query) {
                    $query->select('id', 'category_id', 'name', 'alt', 'locale');
                }])
                ->with(['childs' => function ($query) {
                    $query->select('id')->with(['translations' => function ($query) {
                        $query->select('id', 'category_id');
                    }]);
                }])
                ->featured()
                ->get();

            $categories_products = [];
            foreach ($level_1_categories as $level_1_category) {
                $all_level3_categories_for_level_2_categories = [];

                $level_2_categories = $level_1_category->childs()
                    ->get();

                if (count($level_2_categories) > 0) {
                    foreach ($level_2_categories as $level_2_category) {
                        $level_3_categories = $level_2_category->childs()
                            ->pluck('id')->toArray();
                        $all_level3_categories_for_level_2_categories =
                            array_merge(
                                $all_level3_categories_for_level_2_categories,
                                $level_3_categories
                            );
                    }
                }

                $shop_products =
                    ShopProduct::whereIn(
                        'category_id',
                        $all_level3_categories_for_level_2_categories
                    )->where('qty' ,'!=' ,'0')
                    ->forHome()->featured()->get();

                array_push(
                    $categories_products,
                    [
                        'category' => new CategoryNameImageOnlyResource($level_1_category),
                        'products' => new ShopProductsForHomeCollection($shop_products, $user)
                    ]
                );
            }

            $results['categoriesProducts'] = $categories_products;

            return $this->result = [
                'validator' => null,
                'success' => 'Level 1 categories and their products',
                'errors' => null, 'object' => $results
            ];
        } catch (\Exception $exception) {
            return $this->result = [
                'validator' => null,
                'success' => null, 'errors' => $exception, 'object' => null
            ];
        }
    }
    
    public function filterAllProducts()
    {
        $firstSearch = request()->input('main_search', null);
        $getAll = request()->input('limit', false); // Retrieve 'getAll' from the request with a default value of false

    
        $firstSearchResult = ShopProduct::where('shop_products.show', 1)->whereNotNull('shop_products.qty')
    	->where('shop_products.qty', '>', 0)
            // Join translations tables with unique aliases if needed
            ->join('shop_product_translations as spt', 'spt.shop_product_id', '=', 'shop_products.id')
            ->join('brand_translations as bt', 'bt.brand_id', '=', 'shop_products.brand_id')
            // Explicitly select the required columns to avoid ID conflicts
            ->select('shop_products.id', 'shop_products.sku_code', 'spt.name as product_name', 'spt.description', 'bt.name as brand_name')
            // Handle the search logic
            ->when($firstSearch, function ($query) use ($firstSearch) {
                return $query->where(function ($query) use ($firstSearch) {
                    $query->where('spt.name', 'LIKE', "%{$firstSearch}%")
                          ->orWhere('spt.name', 'LIKE', "%" . str_replace('ى', 'ي', $firstSearch) . "%")
                          ->orWhere('spt.description', 'LIKE', "%{$firstSearch}%")
                          ->orWhere('spt.description', 'LIKE', "%" . str_replace('ى', 'ي', $firstSearch) . "%")
                          ->orWhere('shop_products.sku_code', 'LIKE', "%{$firstSearch}%")
                          ->orWhere('bt.name', 'LIKE', "%{$firstSearch}%")
                          ->orWhere('bt.name', 'LIKE', "%" . str_replace('ى', 'ي', $firstSearch) . "%");
                });
            });
            
        if ($getAll == true) {
        // Use limit(10) and call get() to retrieve the results
        $results['products'] = ShopProductResource::collection($firstSearchResult->limit(10)->get());
            return $this->result = [
                'validator' => null, 
                'success' => 'Product Result', 
                'errors' => null, 
                'object' => $results
            ];
        }
        
        // Step 1: Get all product IDs (before filtering)
        $allProductIds = $firstSearchResult->pluck('shop_products.id')->toArray();
        
        // Gather input for filtering
        $input_specifications = request()->input('specification', []); // Default to an empty array if not provided
        $input_brands = request()->input('brand', []);
        $min_price = request()->input('min_price', null);
        $max_price = request()->input('max_price', null);
        $search = request()->input('search', null);
        $sort_by = request()->input('Options', null); // Default sort by 'qty'
        $sort_order = request()->input('sort_order', 'desc'); // Default sort order 'desc'
    
    
    
        // Check how many products are available before filtering
        $productCountBeforeFilters = count($allProductIds);
        if ($productCountBeforeFilters === 0) {
            return $this->result = ['validator' => null, 'success' => 'No product found', 'errors' => null, 'object' => []];
        }
            
        // Step 2: Filter and search products globally
        $products = $firstSearchResult
            ->select('shop_products.*')
            ->leftJoin('shop_product_translations', 'shop_products.id', '=', 'shop_product_translations.shop_product_id')
            ->leftJoin('brands', 'shop_products.brand_id', '=', 'brands.id')
            ->leftJoin('brand_translations', 'brands.id', '=', 'brand_translations.brand_id')
            ->distinct('shop_products.id')
            ->when($input_specifications, function ($query) use ($input_specifications) {
                // Filter by specifications
                $shop_product_values = ShopProductSpecification::whereIn('id', $input_specifications)
                    ->distinct()
                    ->select('specification_id', 'value')
                    ->get();
                $specifications = $shop_product_values->pluck('specification_id')->toArray();
                $values = $shop_product_values->pluck('value')->toArray();
    
                foreach ($specifications as $specification) {
                    $query->whereIn('shop_products.id', ShopProductSpecification::where('specification_id', $specification)
                        ->whereIn('value', $values)
                        ->pluck('shop_product_id')
                        ->toArray());
                }
                return $query;
            })
            ->when($input_brands, function ($query) use ($input_brands) {
                // Filter by selected brands
                return $query->whereIn('shop_products.brand_id', $input_brands);
            })
            ->when($min_price, function ($query) use ($min_price) {
                // Filter by minimum price
                return $query->where('new_price', '>=', $min_price);
            })
            ->when($max_price, function ($query) use ($max_price) {
                // Filter by maximum price
                return $query->where('new_price', '<=', $max_price);
            })
            ->when($search, function ($query) use ($search) {
                // Filter by search keyword, handling both the standard form and Arabic character variations
                return $query->where(function ($query) use ($search) {
                    $query->where('shop_product_translations.name', 'LIKE', "%{$search}%")
                          ->orWhere('shop_product_translations.name', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%")
                          ->orWhere('shop_product_translations.description', 'LIKE', "%{$search}%")
                          ->orWhere('shop_product_translations.description', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%")
                          ->orWhere('shop_products.sku_code', 'LIKE', "%{$search}%")
                          ->orWhere('brand_translations.name', 'LIKE', "%{$search}%")
                          ->orWhere('brand_translations.name', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%");
                });
            })
            ->when($sort_by, function ($query) use ($sort_by, $sort_order) {
                // Handle sorting options
                switch ($sort_by) {
                    case 'latest':
                        return $query->orderBy('shop_products.created_at', 'desc');
                    case 'highest price':
                        return $query->orderBy('shop_products.new_price', 'desc');
                    case 'lowest price':
                        return $query->orderBy('shop_products.new_price', 'asc');
                    default:
                        return $query->orderBy($sort_by, $sort_order);
                }
            })
            ->tap(function ($query) use (&$products_ids) {
                // Capture the filtered product IDs
                $products_ids = array_unique($query->pluck('shop_products.id')->toArray());
            })
            ->paginate(25) // Pagination for the filtered products
            ->appends(request()->except('page')); // Append filters for pagination links
    
        // Step 3: Prepare filters for response
        $filter = [];
    
        // Retrieve all specifications and their values for the products (based on filtered product IDs)
        $specifications = Specification::whereIn(
            'id',
            ShopProductSpecification::whereIn('shop_product_id', $allProductIds)
                ->whereNotNull('value')
                ->distinct()
                ->pluck('specification_id')
                ->toArray()
        )->get()->sortBy('weight', SORT_DESC);
        // dd($products);
        // Format specifications for response
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
    
        // Add the specifications filter to the filter array
        array_push($filter, [
            'type' => __('home.specifications'),
            'key'  => 'specifications',
            'list' => $allSpecifications
        ]);
    
        // Step 4: Retrieve brands based on the filtered products
        // Get the distinct brand IDs from the filtered products
        $filteredBrandIds = ShopProduct::whereIn('id', $products_ids)
            ->whereNotNull('brand_id')
            ->pluck('brand_id')
            ->unique()
            ->toArray();
    
        // Retrieve the brands associated with the filtered products
        $brands = Brand::whereIn('id', $filteredBrandIds)->get();
    
        // Format the brand filter for the response
        array_push($filter, [
            'type' => __('home.brands'),
            'key'  => 'brands',
            'list' => BrandResource::collection($brands)
        ]);
    
        // Add price filter based on the products after filtering
        array_push($filter, [
            'type' => __('home.price'),
            'key'  => 'price',
            'min_price' => $products->pluck('new_price')->min(),
            'max_price' => $products->pluck('new_price')->max(),
        ]);
        
        // Step 5: Prepare the response with products, filters, and pagination
        $results['products'] = ShopProductResource::collection($products);
        $results['filter'] = $products->total() == 0 ? [] : $filter;
        $results['pagination'] = $products->total() == 0 ? [] : General::createPaginationArray($products);
    
        // Return the final response
        return $this->result = ['validator' => null, 'success' => 'Product Filter', 'errors' => null, 'object' => $results];
    }
  
  	public function countFilterAllProducts()
    {
        $firstSearch = request()->input('main_search', null);
        $getAll = request()->input('limit', false); // Retrieve 'getAll' from the request with a default value of false

    
        $firstSearchResult = ShopProduct::where('shop_products.show', 1)
            // Join translations tables with unique aliases if needed
            ->join('shop_product_translations as spt', 'spt.shop_product_id', '=', 'shop_products.id')
            ->join('brand_translations as bt', 'bt.brand_id', '=', 'shop_products.brand_id')
            // Explicitly select the required columns to avoid ID conflicts
            ->select('shop_products.id', 'shop_products.sku_code', 'spt.name as product_name', 'spt.description', 'bt.name as brand_name')
            // Handle the search logic
            ->when($firstSearch, function ($query) use ($firstSearch) {
                return $query->where(function ($query) use ($firstSearch) {
                    $query->where('spt.name', 'LIKE', "%{$firstSearch}%")
                          ->orWhere('spt.name', 'LIKE', "%" . str_replace('ى', 'ي', $firstSearch) . "%")
                          ->orWhere('spt.description', 'LIKE', "%{$firstSearch}%")
                          ->orWhere('spt.description', 'LIKE', "%" . str_replace('ى', 'ي', $firstSearch) . "%")
                          ->orWhere('shop_products.sku_code', 'LIKE', "%{$firstSearch}%")
                          ->orWhere('bt.name', 'LIKE', "%{$firstSearch}%")
                          ->orWhere('bt.name', 'LIKE', "%" . str_replace('ى', 'ي', $firstSearch) . "%");
                });
            });
            
        if ($getAll == true) {
        // Use limit(10) and call get() to retrieve the results
        $results['products'] = ShopProductResource::collection($firstSearchResult->limit(10)->get());
            return $this->result = [
                'validator' => null, 
                'success' => 'Product Result', 
                'errors' => null, 
                'object' => $results
            ];
        }
        
        // Step 1: Get all product IDs (before filtering)
        $allProductIds = $firstSearchResult->pluck('shop_products.id')->toArray();
        
        // Gather input for filtering
        $input_specifications = request()->input('specification', []); // Default to an empty array if not provided
        $input_brands = request()->input('brand', []);
        $min_price = request()->input('min_price', null);
        $max_price = request()->input('max_price', null);
        $search = request()->input('search', null);
        $sort_by = request()->input('Options', null); // Default sort by 'qty'
        $sort_order = request()->input('sort_order', 'desc'); // Default sort order 'desc'
    
    
    
        // Check how many products are available before filtering
        $productCountBeforeFilters = count($allProductIds);
        if ($productCountBeforeFilters === 0) {
            return $this->result = ['validator' => null, 'success' => 'No product found', 'errors' => null, 'object' => []];
        }
            
        // Step 2: Filter and search products globally
        $productsCount = $firstSearchResult
            ->select('shop_products.*')
            ->leftJoin('shop_product_translations', 'shop_products.id', '=', 'shop_product_translations.shop_product_id')
            ->leftJoin('brands', 'shop_products.brand_id', '=', 'brands.id')
            ->leftJoin('brand_translations', 'brands.id', '=', 'brand_translations.brand_id')
            ->distinct('shop_products.id')
            ->when($input_specifications, function ($query) use ($input_specifications) {
                // Filter by specifications
                $shop_product_values = ShopProductSpecification::whereIn('id', $input_specifications)
                    ->distinct()
                    ->select('specification_id', 'value')
                    ->get();
                $specifications = $shop_product_values->pluck('specification_id')->toArray();
                $values = $shop_product_values->pluck('value')->toArray();
    
                foreach ($specifications as $specification) {
                    $query->whereIn('shop_products.id', ShopProductSpecification::where('specification_id', $specification)
                        ->whereIn('value', $values)
                        ->pluck('shop_product_id')
                        ->toArray());
                }
                return $query;
            })
            ->when($input_brands, function ($query) use ($input_brands) {
                // Filter by selected brands
                return $query->whereIn('shop_products.brand_id', $input_brands);
            })
            ->when($min_price, function ($query) use ($min_price) {
                // Filter by minimum price
                return $query->where('new_price', '>=', $min_price);
            })
            ->when($max_price, function ($query) use ($max_price) {
                // Filter by maximum price
                return $query->where('new_price', '<=', $max_price);
            })
            ->when($search, function ($query) use ($search) {
                // Filter by search keyword, handling both the standard form and Arabic character variations
                return $query->where(function ($query) use ($search) {
                    $query->where('shop_product_translations.name', 'LIKE', "%{$search}%")
                          ->orWhere('shop_product_translations.name', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%")
                          ->orWhere('shop_product_translations.description', 'LIKE', "%{$search}%")
                          ->orWhere('shop_product_translations.description', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%")
                          ->orWhere('shop_products.sku_code', 'LIKE', "%{$search}%")
                          ->orWhere('brand_translations.name', 'LIKE', "%{$search}%")
                          ->orWhere('brand_translations.name', 'LIKE', "%" . str_replace('ى', 'ي', $search) . "%");
                });
            })
            ->when($sort_by, function ($query) use ($sort_by, $sort_order) {
                // Handle sorting options
                switch ($sort_by) {
                    case 'latest':
                        return $query->orderBy('shop_products.created_at', 'desc');
                    case 'highest price':
                        return $query->orderBy('shop_products.new_price', 'desc');
                    case 'lowest price':
                        return $query->orderBy('shop_products.new_price', 'asc');
                    default:
                        return $query->orderBy($sort_by, $sort_order);
                }
            })
            ->tap(function ($query) use (&$products_ids) {
                // Capture the filtered product IDs
                $products_ids = array_unique($query->pluck('shop_products.id')->toArray());
            })
            ->count(); 
        
        // Step 5: Prepare the response with products, filters, and pagination
        $results['products_count'] = $productsCount;
    
        // Return the final response
        return $this->result = ['validator' => null, 'success' => 'Product Filter', 'errors' => null, 'object' => $results];
    }
    
    public function filterProductsByBrand()
    {
        $firstSearch = request()->input('main_search', null);
    
        // Query brands that match the search term, limited to 10 results
        $brandIds = BrandTranslation::where(function ($query) use ($firstSearch) {
                $query->where('name', 'LIKE', "%{$firstSearch}%")
                      ->orWhere('name', 'LIKE', "%" . str_replace('ى', 'ي', $firstSearch) . "%");
            })
            ->distinct()
            ->limit(10)
            ->pluck('brand_id')
            ->toArray();
            
        $brands = Brand::whereIn('id', $brandIds)->get();
        // Prepare the results as an array
        $results = [
            'brands' => BrandResource::collection($brands),
        ];
    
        // Return the results as an array instead of a JsonResponse
        return [
            'validator' => null,
            'success' => 'Filtered Brands',
            'errors' => null,
            'object' => $results,
        ];
    }
  
    public function homeSeo()
    {
      	$setting = Setting::first();
        $results['seo'] = new HomeSeoResource($setting);
        return $this->result = ['validator' => null, 'success' => 'Home Seo', 'errors' => null, 'object' => $results];
    }
}
