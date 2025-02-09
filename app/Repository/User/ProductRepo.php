<?php

namespace App\Repository\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\CompanyProduct;
use App\Models\ProductSpecification;
use App\Models\Company;
use App\Models\SearchStore;
use App\Models\Brand;
use App\Models\Country;
use App\Models\Specification;

use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\Collections\CategoriesCollection;
use App\Http\Resources\Collections\CompaniesCollection;
use App\Http\Resources\Collections\BrandsCollection;
use App\Http\Resources\Collections\ProductsCollection;
use App\Http\Resources\Collections\CountriesCollection;
use App\Http\Resources\Collections\ProductSpecificationsCollection;
use App\Http\Resources\Collections\SpecificationsCollection;

use App\Helpers\General;
class ProductRepo
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
    public function getProducts(){
        set_time_limit(0);
        $request = $this->request;
        $brands_ids = [];
        $categories_ids = [];
        $products_ids = [];
        $in_categories = [];
        $countries_brands = [];
        DB::beginTransaction();
        try {
            //get random results
            if (!session()->has('randProducts'))
            session()->put('randProducts', rand(0, 99999));
            //Request Inputs
            $brands = $request->input('brands');
            $categories = $request->input('categories');
            $countries = $request->input('countries');
            $companies = $request->input('companies');
            $specifications = $request->input('specifications')?$request->input('specifications'):[];
            $from = (double)$request->input('from');
            $to = (double)$request->input('to');
            $key = $request->input('search_key')?$request->input('search_key'):$request->input('s');
            $in_brand = $request->input('in_brand');
            $in_company = $request->input('in_company');
            $in_category = $request->input('in_category');
            $level_category = $request->input('category_level');
            //check if user filter by country, get brands releted to these countries
            if ($countries) {
                $countries_brands = Brand::whereIn('country_id', $countries)->pluck('id')->toArray();
                foreach ($countries_brands as $brand) {
                    if (!in_array($brand, $countries_brands))
                        array_push($countries_brands, $brand);
                }
            }
            //check comming category, if level one or two, get all level three releted to them.
            if ($level_category == 'level1') {
                $category = Category::where('level', $level_category)->find($in_category);
                $l2_categories = $category->childs->pluck('id')->toArray();
                $in_categories = Category::where('level', 'level3')->whereIn('parent', $l2_categories)->pluck('id')->toArray();
            }
            if ($level_category == 'level2')
                $in_categories = Category::where('level', 'level3')->where('parent', $in_category)->pluck('id')->toArray();
            if ($level_category == 'level3')
                array_push($in_categories, $in_category);
            //get product if there are an filter or search query or get all products.
            $products = Product::when($key, function ($query) use ($key) {
                return $query->whereHas('translations', function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%')->orWhere('sku_code', 'like', '%' . $key . '%');
                })->whereHas('brand', function ($query) use ($key) {
                    return $query->whereHas('translations', function ($query) use ($key) {
                        $query->orWhere('name', 'like', '%' . $key . '%');
                    });
                })->whereHas('category', function ($query) use ($key) {
                    return $query->whereHas('translations', function ($query) use ($key) {
                        $query->orWhere('name', 'like', '%' . $key . '%');
                    });
                });
            })->with([
                'translations' => function ($query) {
                    $query->select(['locale', 'name', 'product_id']);
                },
                'category' => function ($query) {
                    $query->select(['id']);
                },
                'brand' => function ($query) {
                    $query->select(['id','image']);
                },
            ])->select(['id', 'brand_id', 'category_id', 'image', 'sku_code'])
                ->when($in_brand, function ($query) use ($in_brand) {
                    return $query->where('brand_id', $in_brand);
                })
                ->when($in_company, function ($query) use ($in_company) {
                    return $query->whereIn('id', CompanyProduct::where('company_id', $in_company)->whereNotNull('product_id')->distinct()->pluck('product_id')->toArray());
                })
                ->when($in_categories, function ($query) use ($in_categories) {
                    return $query->whereIn('category_id', $in_categories);
                })
                ->when($to, function ($query) use ($from, $to) {
                    return $query->whereHas('companyProducts', function ($query) use ($from, $to) {
                        $query->whereBetween('price', [$from, $to]);
                    });
                })
                ->tap(function ($query) use (&$products_ids, &$brands_ids, &$categories_ids) {
                    $products_ids = array_unique($query->pluck('id')->toArray());
                    $brands_ids = array_unique($query->pluck('brand_id')->toArray());
                    $categories_ids = array_unique($query->pluck('category_id')->toArray());
                })
                ->where(function ($query) use ($brands, $categories, $countries_brands, $companies, $specifications) {
                    return $query->when($brands, function ($query) use ($brands) {
                        return $query->whereIn('brand_id', $brands);
                    })->when($countries_brands, function ($query) use ($countries_brands) {
                        return $query->whereIn('brand_id', $countries_brands);
                    })->when($categories, function ($query) use ($categories) {
                        return $query->whereIn('category_id', $categories);
                    })->when($companies, function ($query) use ($companies) {
                        return $query->whereIn('id', CompanyProduct::whereIn('company_id', $companies)->whereNotNull('product_id')->distinct()->pluck('product_id')->toArray());
                    })->when($specifications, function ($query) use ($specifications) {
                        $poduct_values = ProductSpecification::whereIn('id', $specifications)->distinct()->select('specification_id','value')->get();
                        $specifications = $poduct_values->pluck('specification_id')->toArray();
                        $values = $poduct_values->pluck('value')->toArray();
                        foreach($specifications as $specification)
                             $query->whereIn('id', ProductSpecification::where('specification_id',$specification)->whereIn('value',$values)->pluck('product_id')->toArray());
                        return $query;
                    });
                })->groupBy('products.id')->select('products.*')->orderBy(DB::raw('RAND(' . session()->get('randProducts') . ')'))->paginate(21)->appends($request->except('page'));

                // $products = General::paginateArray($products, $this->request->query(), 21);
                $results['products'] = new ProductsCollection($products);
                $results['products_ids'] = $products_ids;
                $results['pagination'] = General::createPaginationArray($products);
                $results['total'] = $results['pagination']['total'];
                //get data used in filter box
                $results['countries'] = new CountriesCollection(Country::whereIn('id', Brand::whereIn('id', $brands_ids)->pluck('country_id'))->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE),$countries?$countries:[]);
                $results['categories'] = new CategoriesCollection(Category::where('level', 'level3')->whereIn('id', $categories_ids)->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE),$categories?$categories:[]);
                $results['companies'] = new CompaniesCollection(Company::where('hidden', 1)->whereIn('id', CompanyProduct::whereIn('product_id', $products_ids)->whereNotNull('product_id')->groupBy('company_id')->pluck('company_id')->toArray())->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE),$companies?$companies:[]);
                $results['brands'] = new BrandsCollection(Brand::whereIn('id', $brands_ids)->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE),$brands?$brands:[]);
                $results['specifications'] =$level_category=='level3'?new SpecificationsCollection(Specification::whereIn('id',ProductSpecification::whereIn('product_id', $products_ids)->whereNotNull('value')->distinct()->pluck('specification_id')->toArray())->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE),$specifications,$products_ids):[];
                $results['fromPrice'] = $from;
                $results['toPrice'] = $to;

                //get filterd brands or categories or countries or companies(used in web, need to refactor to be same as mobile api)
                $results['filterd_brands'] = $brands? new BrandsCollection(Brand::find($brands)->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE)):null;
                $results['filterd_categories'] =$categories ? new CategoriesCollection(Category::where('level', 'level3')->find($categories)->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE)):null;
                $results['filterd_countries'] = $countries ?new CountriesCollection(Country::find($countries)->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE)):null;
                $results['filterd_companies'] = $companies? new CompaniesCollection(Company::find($companies)->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE)):null;
                $results['filterd_specifications'] = $specifications? new ProductSpecificationsCollection(ProductSpecification::find($specifications)->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE)):null;
                //when filter from box that in categories page.
                $results['category'] = $request->input('in_category')?new CategoryResource(Category::find($request->input('in_category'))):null;
                $results['category_id'] = $request->input('in_category');
                $results['category_level'] = $request->input('category_level');
                //if come from in brandProducts page
                $results['brand'] = $request->input('in_brand')?new BrandResource(Brand::find($request->input('in_brand'))):null;
                //if come from in companyProducts page
                $results['company'] = $request->input('in_company')?new CompanyResource(Company::find($request->input('in_company'))):null;
                //when come from search page.
                $results['key'] = $key;
                //store search value in DB
                if($key){
                    SearchStore::create(['search_type'=>'product','search_value'=>$key]);
                    DB::commit();
                }
                return $this->result = ['validator' => null, 'success' => 'List of products','errors'=>null,'object'=>$results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception,'object'=>null];
        }
    }

    /**
     * Get Single produt data.
     *
     *@param $id
     *
     *@return colloection of data
     */
    public function product($id){
        set_time_limit(0);
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            if($product){
                $results['product'] = new ProductResource($product);
                $results['releatedProducts']  = new ProductsCollection(Product::where('id', '!=', $product->id)->where('category_id', $product->category_id)->groupBy('id')->limit(6)->get());
               return $this->result = ['validator' => null, 'success' => 'Product Details','errors'=>null,'object'=>$results];
            }
            return $this->result = ['validator' => 'Product not found !', 'success' => null,'errors'=>null,'object'=>null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception,'object'=>null];
        }
    }
}
