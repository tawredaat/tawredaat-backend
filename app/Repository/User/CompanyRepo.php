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
use App\Models\CompanyTypes;
use App\Models\ViewInformation;
use App\Models\CallbackRequest;
use App\Models\WhatsappCall;
use App\Models\MoreInfo;
use App\Models\PdfDownload;
use App\Models\GeneralRfq;
use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\Country;
use App\Models\Area;
use App\Models\AreaCompany;
use App\Models\CompanyType;
use App\Models\SearchStore;
use App\Http\Resources\AreaResource;
use App\Http\Resources\CompanyTypesResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\Collections\AreasCollection;
use App\Http\Resources\Collections\CompanyTypesCollection;
use App\Http\Resources\Collections\CategoriesCollection;
use App\Http\Resources\Collections\CompaniesCollection;
use App\Http\Resources\Collections\BrandsCollection;
use App\Http\Resources\Collections\ProductsCollection;
use App\Http\Resources\Collections\CountriesCollection;
use App\Http\Resources\Collections\CompanyBranchesCollection;
use App\Helpers\General;
class CompanyRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }

    public function getCompanies(){
        set_time_limit(0);
        $request = $this->request;
        $brand_categories  = [];
        $brands_in_category = [];
        DB::beginTransaction();
        try {
            $categories = $request->input('categories');
            $brands     = $request->input('brands');
            $areas      = $request->input('areas');
            $types      = $request->input('types');
            $key        = $request->input('search_key')?$request->input('search_key'):$request->input('s');
            $keyword    = $request->input('in_keyword');
            $in_category = $request->input('in_category');
            //check if filter by categories , get all brands related to these categories
            if ($categories) {
                $brands_category = BrandCategory::whereIn('category_id',$categories)->distinct()->pluck('brand_id')->toArray();
                foreach ($brands_category as $br) {
                    if (!in_array($br,$brand_categories))
                        array_push($brand_categories, $br);
                }
            }
            if($in_category){
                $brands_in_category = BrandCategory::where('category_id',$in_category)->distinct()->pluck('brand_id')->toArray();
                foreach ($brands_in_category as $br) {
                    if (!in_array($br,$brands_in_category))
                        array_push($brands_in_category, $br);
                }
            }
            //search query(filter in companies by user input)
            $companies  = Company::select('companies.*')
            ->join('company_translations',   'companies.id', '=', 'company_translations.company_id')
            ->leftJoin('company_products',   'companies.id', '=', 'company_products.company_id')
            ->leftJoin('company_company_type',   'companies.id', '=', 'company_company_type.company_id')
            ->leftJoin('area_company',   'companies.id', '=', 'area_company.company_id')
            ->when($key, function ($query) use ($key) {
                return $query->whereHas('translations', function ($query) use ($key) {
                    $query->where('name', 'like', '%' . $key . '%')->orWhere('keywords', 'like', '%' . $key . '%');
                });
            })
            ->when($keyword, function ($query) use ($keyword) {
                return $query->whereHas('translations', function ($query) use ($keyword) {
                    $query->where('keywords', 'like', '%' . $keyword . '%');
                });
            })
            ->when($brands_in_category, function ($query) use ($brands_in_category) {
                return $query->whereNotNull('company_products.product_id')->whereIn('company_products.brand_id', $brands_in_category);
            })
            ->when($brands, function ($query) use ($brands) {
                return $query->whereNotNull('company_products.product_id')->whereIn('company_products.brand_id', $brands);
            })
            ->when($brand_categories, function ($query) use ($brand_categories) {
                return $query->whereNotNull('company_products.product_id')->whereIn('company_products.brand_id', $brand_categories);
            })
            ->when($areas, function ($query) use ($areas) {
                return $query->whereIn('area_company.area_id', $areas);
            })
            ->when($types, function ($query) use ($types) {
                return $query->whereIn('company_company_type.company_type_id', $types);
            })->where('hidden',1)->orderByRaw("CAST(rank as UNSIGNED) DESC")->groupBy('companies.id')
            ->tap(function ($query) use (&$companies_ids) {
                $companies_ids = array_unique($query->pluck('id')->toArray());
            })->groupBy('companies.id')->select('companies.*')->paginate(21)->appends($request->except('page'));
            // $companies = General::paginateArray($companies, $this->request->query(), 21);
            $results['companies'] = new CompaniesCollection($companies);
            $results['pagination'] = General::createPaginationArray($companies);
            $results['total'] = $results['pagination']['total'];
            if($brands)
                $results['brands'] = new BrandsCollection(Brand::whereIn('id',CompanyProduct::whereNotNull('company_products.product_id')->whereIn('company_id',$companies_ids)->distinct()->pluck('brand_id'))->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE),$brands);
            else
                $results['brands'] = new BrandsCollection(Brand::whereIn('id',CompanyProduct::whereNotNull('company_products.product_id')->whereIn('company_id',$companies_ids)->distinct()->pluck('brand_id'))->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE));
            if($areas)
                $results['areas'] = new AreasCollection(Area::whereIn('id',AreaCompany::whereIn('company_id',$companies_ids)->distinct()->pluck('area_id'))->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE),$areas);
            else
                $results['areas'] = new AreasCollection(Area::whereIn('id',AreaCompany::whereIn('company_id',$companies_ids)->distinct()->pluck('area_id'))->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE));

            if($types)
                $results['types'] = new CompanyTypesCollection(CompanyType::whereIn('id',CompanyTypes::whereIn('company_id',$companies_ids)->distinct()->pluck('company_type_id'))->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE),$types);
            else
                $results['types'] = new CompanyTypesCollection(CompanyType::whereIn('id',CompanyTypes::whereIn('company_id',$companies_ids)->distinct()->pluck('company_type_id'))->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE));
            if($categories)
                $results['categories'] = new CategoriesCollection(Category::where('level','level3')->whereIn('id',BrandCategory::WhereIn('brand_id',CompanyProduct::whereNotNull('product_id')->whereIn('company_id',$companies_ids)->distinct()->pluck('brand_id'))->distinct()->pluck('category_id'))->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE),$categories);
            else
                $results['categories'] = new CategoriesCollection(Category::where('level','level3')->whereIn('id',BrandCategory::WhereIn('brand_id',CompanyProduct::whereNotNull('product_id')->whereIn('company_id',$companies_ids)->distinct()->pluck('brand_id'))->distinct()->pluck('category_id'))->get()->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE));

            //this code used in web
            $results['filterd_brands']= $brands?new BrandsCollection(Brand::find($brands)->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE)):null;
            $results['filterd_categories'] = $categories? new CategoriesCollection(Category::where('level','level3')->find($categories)->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE)):null;
            $results['filterd_areas'] = $areas?new AreasCollection(Area::find($areas)->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE)):null;
            $results['filterd_types'] = $types? new CompanyTypesCollection(CompanyType::find($types)->sortBy('name',SORT_NATURAL|SORT_FLAG_CASE)):null;
            //***********/

            $results['category'] =$in_category?new CategoryResource(Category::where('level','level3')->find($in_category)):null;
            $results['keyword']=$keyword;
            $results['key']=$key;
            if ($key)
                SearchStore::create(['search_type'=>'company','search_value'=>$key]);
            return $this->result = ['validator' => null, 'success' => 'List of companies','errors'=>null,'object'=>$results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception,'object'=>null];
        }
    }

    public function company($id){
        set_time_limit(0);
        $relatedCompanies = [];
        $products = [];
        $keywords = [];
        DB::beginTransaction();
        try {
            $company = Company::find($id);
            if($company){
                $results['company'] = new CompanyResource($company);
                //store view information data
                ViewInformation::create([
                    'company_id' => $company->id,
                    'user_id'    =>  auth()->check()?(auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id):null,
                ]);
                DB::commit();
                //get related companies to a company
                $CompanyBrand = CompanyProduct::where('company_id',$id)->first();
                if ($CompanyBrand) {
                    $reltCompanies = CompanyProduct::where('company_id','!=',$id)->where('brand_id',$CompanyBrand->brand_id)->limit(6)->get();
                    foreach ($reltCompanies as $C) {
                        if (!in_array($C->company, $relatedCompanies))
                            array_push($relatedCompanies,$C->company);
                    }
                }
                $results['relatedCompanies'] = new CompaniesCollection($relatedCompanies);
                //get products of a company
                foreach ($company->products as $CP) {
                    if (count($products) < 9) {
                        if (!in_array($CP->product, $products))
                            array_push($products,$CP->product);
                    }
                }
                $results['products'] = new ProductsCollection($products);

                //get brands of a company
                $approved_brands = CompanyProduct::where('company_id',$company->id)->where('approve',2)->groupBy('brand_id')->pluck('brand_id')->toArray();
                $results['brands']    = new BrandsCollection(Brand::find($approved_brands));

                //get categories if a company
                $results['categories'] = new CategoriesCollection(Category::where('level','level3')->whereIn('id',BrandCategory::WhereIn('brand_id',CompanyProduct::where('company_id',$id)->pluck('brand_id'))->pluck('category_id'))->get());

                //get branches if a company
                $results['branches'] = new CompanyBranchesCollection($company->branches);

                //gey keywords of a company
                if ($company->keywords)
                    $keywords = explode(',', $company->keywords);
                $results['keywords'] = $keywords;

               return $this->result = ['validator' => null, 'success' => 'Company Details','errors'=>null,'object'=>$results];
            }
            return $this->result = ['validator' => 'Company not found !', 'success' => null,'errors'=>null,'object'=>null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception,'object'=>null];
        }
    }

    /**
     * Store user info after call Company using Phone
     *
     * @return Colloection of data
     */
    public function callByPhone(){
        $request = $this->request;
        DB::beginTransaction();
        try {
            CallbackRequest::create([
               'company_id' => $request->input('companyID'),
               'user_id'    =>  auth()->check()?(auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id):null,
            ]);
            DB::commit();
            return $this->result = ['validator' => null, 'success' => __('home.callRequestMssg'), 'errors' => null,'object'=>null];
        }catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception,'object'=>null];
        }
    }

    /**
     * Store user info after conect with the company using Whatsapp
     *
     * @return Colloection of data
     */
    public function connectByWhatsapp(){
        $request = $this->request;
        DB::beginTransaction();
        try {
            WhatsappCall::create([
               'company_id' => $request->input('companyID'),
               'user_id'    =>  auth()->check()?(auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id):null,
            ]);
            DB::commit();
            return $this->result = ['validator' => null, 'success' => __('home.callRequestMssg'), 'errors' => null,'object'=>null];
        }catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception,'object'=>null];
        }
    }
    /**
     * Request General quotaion
     *
     * @return Colloection of data
     */
    public function requestGeneralQuotation(){
        $request = $this->request;
        DB::beginTransaction();
        try {
            GeneralRfq::create([
                'company_id' => $request->input('companyID'),
                'user_id'    => auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id,
                'message'    =>$request->input('msg'),
             ]);
            DB::commit();
            return $this->result = ['validator' => null, 'success' => __('home.requestGeneralQuotaionMsg'), 'errors' => null,'object'=>null];
        }catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception,'object'=>null];
        }
    }

    /**
     * Click on view More information btn
     *
     * @return Colloection of data
     */
    public function viewMoreInfo(){
        $request = $this->request;
        DB::beginTransaction();
        try {
             MoreInfo::create([
                'company_id' => $request->input('companyID'),
                'user_id'    => auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id,
             ]);
            DB::commit();
            return $this->result = ['validator' => null, 'success' => __('home.done'), 'errors' => null,'object'=>null];
        }catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception,'object'=>null];
        }
    }
    /**
     * Click on download PDF  btn
     *
     * @return Colloection of data
     */
    public function downloadPDF(){
        $request = $this->request;
        DB::beginTransaction();
        try {
            PdfDownload::create([
                'company_id' => $request->input('companyID'),
                'user_id'    => auth('web')->user()?auth('web')->user()->id:auth('api')->user()->id,
                'pdf'        => $request->input('click'),
            ]);
            DB::commit();
            return $this->result = ['validator' => null, 'success' => __('home.done'), 'errors' => null,'object'=>null];
        }catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception,'object'=>null];
        }
    }
}
