<?php

namespace App\Repository\User;

use App\Helpers\General;
use App\Http\Resources\BrandBannerResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\BrandShowResource;
use App\Http\Resources\ShopProductResource;
use App\Http\Resources\BrandSeoResource;
use App\Http\Resources\PageSeoResource;
use App\Http\Resources\Collections\BrandDistributorsCollection;
use App\Http\Resources\Collections\ShopProductSpecificationsCollection;
use App\Http\Resources\Collections\BrandsCollection;
use App\Http\Resources\Collections\CategoriesCollection;
use App\Http\Resources\Collections\CompaniesCollection;
use App\Http\Resources\Collections\CompanyTypesCollection;
use App\Http\Resources\Collections\CountriesCollection;
use App\Http\Resources\Collections\SpecificationsCollection;
use App\Models\Brand;
use App\Models\Seo;
use App\Models\ShopProduct;
use App\Models\BrandBanner;
use App\Models\BrandCategory;
use App\Models\Category;
use App\Models\Company;
use App\Models\CompanyProduct;
use App\Models\CompanyType;
use App\Models\Country;
use App\Models\SearchStore;
use App\Models\Specification;
use App\Models\ShopProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }

    public function getBrands()
    {
        set_time_limit(0);
        $request = $this->request;

        try {
            //get random brands
            if (!session()->has('randSearchBrands')) {
                session()->put('randSearchBrands', rand(0, 99999));
            }

            //Request Inputs
            $categories = $request->input('categories');
            $countries = $request->input('countries');
            $companies = $request->input('companies');
            $key = $request->input('search_key') ? $request->input('search_key') : $request->input('s');
            $keyword = $request->input('in_keyword');
            $in_category = $request->input('in_category');

            $brands = Brand::where('show',1)->with([
                'translations' => function ($query) {$query->select(['locale', 'name', 'brand_id', 'keywords']);},
                'country' => function ($query) {$query->select(['id', 'flag']);},
            ])->when($key, function ($query) use ($key) {
                return $query->whereHas('translations', function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%')->orWhere('keywords', 'like', '%' . $key . '%');
                });
            })
                ->when($in_category, function ($query) use ($in_category) {
                    return $query->whereHas('brandCategories', function ($query) use ($in_category) {
                        $query->where('category_id', $in_category);
                    });
                })->when($keyword, function ($query) use ($keyword) {
                return $query->whereHas('translations', function ($query) use ($keyword) {
                    $query->where('keywords', 'like', '%' . $keyword . '%');
                });
            })
                ->tap(function ($query) use (&$brands_ids, &$countries_ids) {
                    $brands_ids = array_unique($query->pluck('id')->toArray());
                    $countries_ids = array_unique($query->pluck('country_id')->toArray());
                })
                ->when($companies, function ($query) use ($companies) {
                    return $query->whereHas('BrandCompanies', function ($query) use ($companies) {
                        $query->whereIn('company_id', $companies);
                    });
                })->when($categories, function ($query) use ($categories) {
                return $query->whereHas('brandCategories', function ($query) use ($categories) {
                    $query->whereIn('category_id', $categories);
                });
            })->when($countries, function ($query) use ($countries) {
                return $query->whereIn('country_id', $countries);
            })
                ->select(['id', 'image', 'country_id','show'])
                ->orderByRaw("CAST(rank as UNSIGNED) DESC")
                ->groupBy('brands.id')->select('brands.*')->paginate(21)->appends($request->except('page'));
            // $brands = General::paginateArray($brands, $this->request->query(), 21);
            $results['brands'] = new BrandsCollection($brands);
            $results['pagination'] = General::createPaginationArray($brands);
            $results['total'] = $results['pagination']['total'];

            if ($countries) {
                $results['countries'] = new CountriesCollection(Country::whereIn('id', $countries_ids)->get()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE), $countries);
            } else {
                $results['countries'] = new CountriesCollection(Country::whereIn('id', $countries_ids)->get()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE));
            }

            if ($categories) {
                $results['categories'] = new CategoriesCollection(Category::where('level', 'level3')->whereIn('id', BrandCategory::whereIn('brand_id', $brands_ids)->distinct()->pluck('category_id')->toArray())->get()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE), $categories);
            } else {
                $results['categories'] = new CategoriesCollection(Category::where('level', 'level3')->whereIn('id', BrandCategory::whereIn('brand_id', $brands_ids)->distinct()->pluck('category_id')->toArray())->get()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE));
            }

            if ($companies) {
                $results['companies'] = new CompaniesCollection(Company::where('hidden', 1)->whereIn('id', CompanyProduct::whereIn('brand_id', $brands_ids)->distinct()->pluck('company_id')->toArray())->get()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE), $companies);
            } else {
                $results['companies'] = new CompaniesCollection(Company::where('hidden', 1)->whereIn('id', CompanyProduct::whereIn('brand_id', $brands_ids)->distinct()->pluck('company_id')->toArray())->get()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE));
            }

            //this code used in web
            $results['filterd_companies'] = $companies ? new CompaniesCollection(Company::find($companies)->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)) : null;
            $results['filterd_categories'] = $categories ? new CategoriesCollection(Category::where('level', 'level3')->find($categories)->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)) : null;
            $results['filterd_countries'] = $countries ? new CountriesCollection(Country::find($countries)->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)) : null;

            $results['category'] = $in_category ? new CategoryResource(Category::where('level', 'level3')->find($in_category)->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)) : null;
            $results['keyword'] = $keyword;
            $results['key'] = $key;
            if ($key) {
                SearchStore::create(['search_type' => 'brand', 'search_value' => $key]);
            }

            return $this->result = ['validator' => null, 'success' => 'List of brands', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {

            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    /**
     * Get single brand data.
     *
     *@param $id
     *
     *@return colloection of data
     */
    public function brand($id)
    {
        set_time_limit(0);
        $keywords = [];
        $relatedBrands = [];
        DB::beginTransaction();
        try {
            $brand = Brand::find($id);
            if ($brand) {
                $results['brand'] = new BrandResource($brand);
                //get categories of brand
                $results['categories'] = new CategoriesCollection(Category::where('level', 'level3')->whereIn('id', BrandCategory::Where('brand_id', $id)->distinct()->pluck('category_id'))->get());
                //get related brands
                $BrandCategory = BrandCategory::where('brand_id', $id)->first();
                if ($BrandCategory) {
                    $relatedBrands = Brand::where('id', '!=', $id)->whereIn('id', BrandCategory::where('brand_id', '!=', $id)->where('category_id', $BrandCategory->category_id)->pluck('brand_id')->toArray())
                        ->orWhereHas('translations', function ($query) use ($keywords) {
                            $query->orWhere(function ($q) use ($keywords) {
                                foreach ($keywords as $value) {
                                    $q->orWhere('keywords', 'like', '%' . $value . '%');
                                }
                            });
                        })->limit(9)->get();
                }
                $products_ids=[] ;
                $input_specifications = request()->specifications ?request()->specifications : [];
                $products = ShopProduct::where('brand_id' , $id)->orderBy('qty', 'desc')->select('shop_products.*')
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
                        ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
                        $input_specifications,
                        $products_ids
                    ) : [];

                    $filter = [];
                   
                    
                    array_push($filter, ['type' => __('home.specifications'),
                        'key' => 'specifications',
                        'list' => $specifications]);

                $results['filter'] = $filter;
                //$results['selected_filter'] = $selected_filter; 
                $results['products'] = ShopProductResource::collection($products);
                $results['pagination'] = General::createPaginationArray($products);
                $results['relatedBrands'] = new BrandsCollection($relatedBrands);
                //gey keywords of a brand
                if ($brand->keywords) {
                    $keywords = explode(',', $brand->keywords);
                }

                $results['keywords'] = $keywords;

                $results['brandBanners'] = BrandBannerResource::collection(
                    BrandBanner::where('brand_id', $brand->id)->get()
                );

                return $this->result = ['validator' => null, 'success' => 'Brand Details', 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => 'Brand not found !', 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    /**
     * Get companies(distributors) related to a brand
     *
     * @param Request $request,$name,$id
     *
     * @return View
     */
    public function companies($id)
    {
        set_time_limit(0);
        $typesIds = [];
        DB::beginTransaction();
        try {
            $brand = Brand::find($id);
            if ($brand) {
                $brandCompanies = $brand->brandTypeCompanies->whereIn('company_id', CompanyProduct::where('brand_id', $id)->where('approve', 2)->groupBy('company_id')->pluck('company_id')->toArray());
                $brandTypes = $brandCompanies->groupBy('company_type_id');
                foreach ($brandTypes as $key => $value) {
                    array_push($typesIds, $key);
                }
                $results['brandCompanies'] = $brandCompanies;
                $results['companies'] = new CompaniesCollection(Company::find($brandCompanies->pluck('company_id')));
                $results['types'] = new CompanyTypesCollection(CompanyType::find($typesIds));
                //this object used in mobile
                $results['brand'] = new BrandResource($brand);
                $results['distributors'] = new BrandDistributorsCollection(CompanyType::find($typesIds), $brandCompanies);
                return $this->result = ['validator' => null, 'success' => 'List of distributors', 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => 'This brand not found !', 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    
    public function show($id)
    {
        try{
            $results = new BrandResource(Brand::where('id' , $id)->first());
            return $this->result = ['validator' => null, 'success' => 'brand Details','errors'=>null,'object'=>$results];
        }catch (\Exception $exception) {
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }
  
    public function brandSeo($id)
    {
      	$brand = Brand::find($id);
        $results['seo'] = new BrandSeoResource($brand);
        return $this->result = ['validator' => null, 'success' => 'Brand Seo', 'errors' => null, 'object' => $results];
    }
  
    public function brandsSeo()
    {
      	$brands = Seo::where('page_name' , 'brands')->first();
        $results['seo'] = new PageSeoResource($brands);
        return $this->result = ['validator' => null, 'success' => 'Brands Page Seo', 'errors' => null, 'object' => $results];
    }
}
