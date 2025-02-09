<?php

namespace App\Repository\User;

use App\Helpers\General;
use App\Http\Resources\CategoryNameImageOnlyResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryWithSubCategoriesWithoutProductsResource;
use App\Http\Resources\Collections\BannersCollection;
use App\Http\Resources\Collections\BrandsCollection;
use App\Http\Resources\Collections\CategoriesCollection;
use App\Http\Resources\Collections\CountriesCollection;
use App\Http\Resources\Collections\ShopProductsCollection;
use App\Http\Resources\Collections\ShopProductsForHomeCollection;
use App\Http\Resources\Collections\ShopProductSpecificationsCollection;
use App\Http\Resources\Collections\SpecificationsCollection;
use App\Http\Resources\ShopProductResource;
use App\Http\Resources\ShopProductResourceDeleted;
use App\Http\Resources\ProductSeoResource;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Country;
use App\Models\OrderItem;
use App\Models\ShopBanner;
use App\Models\ShopProduct;
use App\Models\ShopProductSpecification;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ShopProductRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }
    /**
     * get products by  search or filter  or get all products.
     *
     * @return colloection of data
     */
    public function getShopProducts()
    {
        set_time_limit(0);
        $request = $this->request;
        $brands_ids = [];
        $categories_ids = [];
        $products_ids = [];
        $in_categories = [];
        $countries_brands = [];
        DB::beginTransaction();
        try {
            $user = auth('web')->user() ? auth('web')->user() : auth('api')->user();
            //Request Inputs
            $brands = $request->input('brands');
            $categories = $request->input('categories');
            $countries = $request->input('countries');
            $companies = $request->input('companies');
            $specifications = $request->input('specifications') ? $request->input('specifications') : [];

            $from = $to = null;
            if ($request->from) {
                $from = (float) $request->input('from');
            } else {
                $from = 0;
            }
            if ($request->to) {
                $to = (float) $request->input('to');
            } else {
                $to = 0;
            }

            $key = $request->input('search_key') ?
                $request->input('search_key') : $request->input('s');
            // remaining
            $in_brand = $request->input('in_brand');
            $in_company = $request->input('in_company');
            $in_category = $request->input('in_category');
            $level_category = $request->input('category_level');

            // check if user filter by country, get brands related to these countries
            if ($countries) {
                $countries_brands = Brand::whereIn('country_id', $countries)->pluck('id')->toArray();
                foreach ($countries_brands as $brand) {
                    if (!in_array($brand, $countries_brands)) {
                        array_push($countries_brands, $brand);
                    }
                }
            }
            //check comming category, if level one or two, get all level three releted to them.
            if ($level_category == 'level1') {
                $category = Category::with('childs')->where('level', $level_category)->find($in_category);
                // sub Categories
                $results['subCategories'] = CategoryNameImageOnlyResource::collection($category->childs);
                $l2_categories = $category->childs->pluck('id')->toArray();
                $in_categories = Category::where('level', 'level3')->whereIn('parent', $l2_categories)->pluck('id')->toArray();
            }
            if ($level_category == 'level2') {
                $category = Category::with('childs')->where('level', $level_category)->find($in_category);
                // sub Categories
                $results['subCategories'] = CategoryNameImageOnlyResource::collection($category->childs);

                $in_categories = Category::where('level', 'level3')
                    ->where('parent', $in_category)->pluck('id')->toArray();
            }

            if ($level_category == 'level3') {
                // sub Categories
                $results['subCategories'] = null;
                array_push($in_categories, $in_category);
            }

            //get product if there are an filter or search query or get all products.
            $products = ShopProduct::where('show',1)
            ->when($key, function ($query) use ($key) {
                return $query->where(function ($query) use ($key) {
                    $query->whereHas('translations', function ($query) use ($key) {
                        $query->where(function ($subQuery) use ($key) {
                            $subQuery->where('name', 'like', '%' . $key . '%')
                                ->orWhere('keywords', 'like', '%' . $key . '%')
                                ->orWhere('description', 'like', '%' . $key . '%');
                        });
                    })
                        ->orWhereHas('specifications', function ($query) use ($key) {
                            $query->where(function ($subQuery) use ($key) {
                                $subQuery->where('value', 'like', '%' . $key . '%');
                            });
                        })
                        ->orWhereHas('category', function ($query) use ($key) {
                            $query->whereHas('translations', function ($query) use ($key) {
                                $query->where(function ($subQuery) use ($key) {
                                    $subQuery->where('name', 'like', '%' . $key . '%');
                                });
                            });
                        })
                        ->orWhereHas('brand', function ($query) use ($key) {
                            $query->whereHas('translations', function ($query) use ($key) {
                                $query->where(function ($subQuery) use ($key) {
                                    $subQuery->where('name', 'like', '%' . $key . '%');
                                });
                            });
                        });
                });
            })->with([
                'translations' => function ($query) {
                    $query->select(['locale', 'name', 'shop_product_id', 'slug']);
                },
                'category' => function ($query) {
                    $query->select(['id']);
                },
                'brand' => function ($query) {
                    $query->select(['id', 'image']);
                },
            ])->select(['id', 'brand_id', 'category_id', 'image', 'sku_code', 'new_price','show'])
                ->when($in_brand, function ($query) use ($in_brand) {
                    return $query->where('brand_id', $in_brand);
                })
                ->when($in_categories, function ($query) use ($in_categories) {
                    return $query->whereIn('category_id', $in_categories);
                })
                ->when($to, function ($query) use ($from, $to) {
                    return $query->whereBetween('new_price', [$from, $to]);
                })
                ->tap(function ($query) use (&$products_ids, &$brands_ids, &$categories_ids) {
                    $products_ids = array_unique($query->pluck('id')->toArray());
                    $brands_ids = array_unique($query->pluck('brand_id')->toArray());
                    $categories_ids = array_unique($query->pluck('category_id')->toArray());
                })
                ->where(function ($query) use (
                    $brands,
                    $categories,
                    $countries_brands,
                    $specifications
                ) {
                    return $query->when($brands, function ($query) use ($brands) {
                        return $query->whereIn('brand_id', $brands);
                    })->when($countries_brands, function ($query) use ($countries_brands) {
                        return $query->whereIn('brand_id', $countries_brands);
                    })->when($categories, function ($query) use ($categories) {
                        return $query->whereIn('category_id', $categories);
                    })->when($specifications, function ($query) use ($specifications) {
                        $shop_poduct_values = ShopProductSpecification::whereIn('id', $specifications)
                            ->distinct()->select('specification_id', 'value')->get();
                        $specifications = $shop_poduct_values->pluck('specification_id')->toArray();
                        $values = $shop_poduct_values->pluck('value')->toArray();
                        foreach ($specifications as $specification) {
                            $query->whereIn('id', ShopProductSpecification::where('specification_id', $specification)
                                ->whereIn('value', $values)->pluck('shop_product_id')->toArray());
                        }
                        return $query;
                    });
                })->groupBy('shop_products.id')
                ->select('shop_products.*')
                ->orderBy('qty','desc')
                ->orderBy('id')

                //->orderBy(DB::raw('RAND(' . session()->get('randProducts') . ')'))
                ->paginate(24)->appends($request->except('page'));

            $results['ShopProducts'] = new ShopProductsForHomeCollection($products, $user);
            $results['products_ids'] = $products_ids;
            $results['pagination'] = General::createPaginationArray($products);
            $results['total'] = $results['pagination']['total'];
            //get data used in filter box
            $results['countries'] = new CountriesCollection(Country::whereIn('id', Brand::whereIn('id', $brands_ids)->pluck('country_id'))->get()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE));

            $results['categories'] =
                new CategoriesCollection(Category::where('level', 'level3')
                    ->whereIn('id', $categories_ids)
                    ->get()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE));

            $results['brands'] = new BrandsCollection(Brand::where('show',1)->whereIn('id', $brands_ids)->get()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE));

            $results['specifications'] = $products_ids ?
                new SpecificationsCollection(
                    Specification::whereIn(
                        'id',
                        ShopProductSpecification::whereIn('shop_product_id', $products_ids)
                            ->whereNotNull('value')->distinct()
                            ->pluck('specification_id')->toArray()
                    )->get()
                        ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
                    $specifications,
                    $products_ids
                ) : [];

            $results['fromPrice'] = $from;
            $results['toPrice'] = $to;

            if ($request->input('in_brand')) {
                // add it to brands
                if (is_null($brands)) {
                    $brands = [];
                }
                array_push($brands, $in_brand);
            }

            //get filterd brands or categories or countries or companies
            $results['filterd_brands'] = $brands ?
                new BrandsCollection(Brand::find($brands)->sortBy(
                    'name',
                    SORT_NATURAL | SORT_FLAG_CASE
                )) : null;

            if ($request->input('in_category')) {
                // add it to categories
                if (is_null($categories)) {
                    $categories = [];
                }
                array_push($categories, $in_category);
            }

            $results['filterd_categories'] = $categories ?
                new CategoriesCollection(Category::find($categories)->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)) : null;

            $results['filterd_countries'] = $countries ? new CountriesCollection(Country::find($countries)->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)) : null;
            $results['filterd_specifications'] =
                $specifications ? new ShopProductSpecificationsCollection(ShopProductSpecification::find($specifications)->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)) : null;
            //when filter from box that in categories page.
            $results['category'] = $request->input('in_category') ?
                new CategoryResource(Category::find($request->input('in_category'))) : null;

            $results['category_id'] = $request->input('in_category');

            $results['category_level'] = $request->input('category_level');

            //when come from search page.
            $results['key'] = $key;
            return $this->result = [
                'validator' => null,
                'success' => 'List of shop products', 'errors' => null, 'object' => $results
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    /**
     * get shop product details.
     *
     *
     * @return colloection of data
     */
    public function show($id)
    {
        try {

            $user = auth('web')->user() ? auth('web')->user() : auth('api')->user();
            $product = ShopProduct::find($id);
            if ($product) {
                $results['breadcrumbs'] = $this->breadcrumbs($product->category);

                $results['shopProduct'] = new ShopProductResource($product, $user);
                $results['releatedProducts'] = new ShopProductsCollection(ShopProduct::where('id', '!=', $product->id)->where('category_id', $product->category_id)->groupBy('id')->limit(6)->get(), $user);

                return $this->result = ['validator' => null, 'success' => 'Shop Product details', 'errors' => null, 'object' => $results];
            } else {
                $results['shopProduct'] = new ShopProductResourceDeleted();
                return $this->result = ['validator' => null, 'success' => __('home.DeletedShopProduct'), 'errors' => null, 'object' => $results];
            }
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    /**
     * get featured shop products..
     *
     * @return BannersCollection
     */
    public function sliders()
    {
        try {
            $results['sliders'] = new BannersCollection(ShopBanner::all());
            return $this->result = ['validator' => null, 'success' => 'Sliders', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    /**
     * get featured shop products..
     *
     * @return ShopProductsCollection
     */
    public function featuredShopProduct()
    {
        try {
            $user = auth('web')->user() ? auth('web')->user() : auth('api')->user();

            $results['featuredShopProducts'] = new ShopProductsCollection(ShopProduct::where('featured', 1)->get(), $user);
            return $this->result = ['validator' => null, 'success' => 'Featured Shop Products', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    /**
     * get categories(Level one categories)..
     *
     * @return CategoriesCollection
     */
    // public function featuredCategories()
    // {
    //     try {
    //         $results['featuredCategories'] =
    //             CategoryWithSubCategoriesWithoutProductsResource::collection(
    //                 Category::where('level', 'level1')
    //                     ->whereIn('id', Category::where('level', 'level2')
    //                         ->whereIn('id', Category::where('level', 'level3')
    //                             ->whereIn(
    //                                 'id',
    //                                 ShopProduct::distinct()
    //                                     ->pluck('category_id')->toArray()
    //                             )
    //                             ->distinct()->pluck('parent')->toArray())
    //                         ->distinct()->pluck('parent'))->get(),
    //                 [],
    //                 'shop'
    //             );
    //         return $this->result = [
    //             'validator' => null,
    //             'success' => 'All Shop Categories', 'errors' => null, 'object' => $results
    //         ];
    //     } catch (\Exception $exception) {
    //         return $this->result = [
    //             'validator' => null, 'success' => null,
    //             'errors' => $exception, 'object' => null
    //         ];
    //     }
    // }
    
    public function featuredCategories()
    {
        try {
            // Get the level one categories with their children (filtered by 'show' equals 1)
            $categories = Category::where('level', 'level1')
                                  ->where('show', 1)
                                  ->with(['childs' => function ($query) {
                                      $query->where('show', 1)->with(['childs' => function ($query) {
                                          $query->where('show', 1);
                                      }]);
                                  }])
                                  ->get();
                                //   ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);
            
            // Create a resource collection from the categories
            $results['featuredCategories'] = CategoryWithSubCategoriesWithoutProductsResource::collection($categories);
        
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
     * get categories(Level three categories) that have shop products..
     *
     * @return CategoriesCollection
     */
    public function LevelThreeCategories($id)
    {
        try {
            $results['LevelThreeCategories'] = new CategoriesCollection(Category::where([['level', 'level3'], ['parent', $id]])->whereIn('id', ShopProduct::distinct()->pluck('category_id')->toArray())->get(), [], 'shop');
            return $this->result = ['validator' => null, 'success' => 'Featured Categories', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    /**
     * get best seller products()..
     *
     * @return ShopProductsCollection
     */
    public function bestSellerProducts()
    {
        try {
            $user = auth('web')->user() ? auth('web')->user() : auth('api')->user();
            $top_ten_soled_products = ShopProduct::whereIn('id', OrderItem::select(['shop_product_id', DB::raw('count(*) as count')])->groupBy('shop_product_id')->orderBy('count', 'DESC')->take(10)->pluck('shop_product_id'))->get();
            $results['bestSellerProducts'] = new ShopProductsCollection($top_ten_soled_products, $user);
            return $this->result = ['validator' => null, 'success' => 'Best Seller Shop Products', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    private function breadcrumbs($category)
    {
        $categories = [];
        $this->getParentCategory($category, $categories);
        return $categories;
    }
  
    public function productSeo($id)
    {
      	$product = ShopProduct::find($id);
        try {
            $results['seo'] = new ProductSeoResource($product);
            return $this->result = ['validator' => null, 'success' => 'Product Seo', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    private function getParentCategory($category, &$categories)
    {
        if (is_null($category->parent)) {
            $categories['category'] = ['id' => $category->id, 'name' => $category->name , 'slug' => Str::slug($category->name)];

            return $category->name;
        }

        if (count($categories) == 0) {
            $categories['tiny_category'] = ['id' => $category->id, 'name' => $category->name , 'slug' => Str::slug($category->name)];
        } else {
            $categories['sub_category'] = ['id' => $category->id, 'name' => $category->name , 'slug' => Str::slug($category->name)  ];
        }

        $parent = Category::where('id', $category->parent)->first();

        return $this->getParentCategory($parent, $categories);
    }
}
