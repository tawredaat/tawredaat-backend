<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\CompanyVisitor;
use App\Http\Requests\User\StoreCallbackRequest;
use App\Http\Requests\User\FilterCompanyRequest;
use App\Http\Requests\User\StoreBtnClickRequest;
use App\Http\Requests\User\StoreGeneralQuotaionRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Repository\User\CompanyRepo;
use App\Repository\User\ProductRepo;
class CompanyController extends Controller
{

    protected $companyRepo;
    protected $productRepo;

    public function __construct(CompanyRepo $companyRepo,ProductRepo $productRepo)
    {
        $this->companyRepo = $companyRepo;
        $this->productRepo = $productRepo;
    }
    /**
     * Get all companies.
     *
     * @param Request $request
     *
     * @return View
     */
	public function index(Request $request)
	{
        $this->companyRepo->setReq($request);
        $result = $this->companyRepo->getCompanies();
        if($result['success']){
            if (!session()->has('company')) {
                session()->put('company', Str::random(10));
                CompanyVisitor::create(['user_id'=>UserID(),'company'=>session()->get('company')]);
            }elseif(session()->has('company') AND isLogged()) {
                CompanyVisitor::where('company',session()->get('company'))->update(['user_id'=>UserID()]);
            }
            $companies = $result['object']['companies'];
            $countCompanies = $result['object']['total'];
            if (Cache::has('companies_brands'))
                $brands =  Cache::get('companies_brands');
            else{
                Cache::put('companies_brands',$result['object']['brands'],now()->addMinutes(1440));
                $brands =  Cache::get('companies_brands');
            }
            if (Cache::has('companies_area'))
                $areas =  Cache::get('companies_area');
            else{
                Cache::put('companies_area',$result['object']['areas'],now()->addMinutes(1440));
                $areas =  Cache::get('companies_area');
            }
            if (Cache::has('companies_types'))
                $types =  Cache::get('companies_types');
            else {
                Cache::put('companies_types',$result['object']['types'],now()->addMinutes(1440));
                $types =  Cache::get('companies_types');
            }
            if (Cache::has('companies_categories'))
                $categories =  Cache::get('companies_categories');
            else {
                Cache::put('companies_categories',$result['object']['categories'],now()->addMinutes(1440));
                $categories =  Cache::get('companies_categories');
            }
            $lang_changed = $this->langChanged();
            return view('User.companies',compact('companies','countCompanies','brands','areas','types','categories','lang_changed'));
        }else
            abort(500);
	}
    /**
     * Show Company page.
     *
     * @param $name, $id
     *
     * @return View
     */
	public function show($name,$id)
	{
        $result = $this->companyRepo->company($id);
        if($result['success']){
            $company = $result['object']['company'];
            $categories = $result['object']['categories'];
            $relatedCompanies = $result['object']['relatedCompanies'];
            $products = $result['object']['products'];
            $brands = $result['object']['brands'];
            $keywords = $result['object']['keywords'];
            $lang_changed = $this->langChanged();
            return view('User.company',compact('company','categories','relatedCompanies','products','brands','keywords','lang_changed'));
        }elseif($result['validator'])
            abort(404);
        else
            abort(500);
    }
    /**
     * Filter companies by categories or brands or areas or types or keywords
     *
     * @param FilterCompanyRequest $request
     *
     * @return View OR \Illuminate\Http\JsonResponse
     */
    public function filterCompanies(FilterCompanyRequest $request){
        $this->companyRepo->setReq($request);
        $result = $this->companyRepo->getCompanies();
        if($result['success']){
            if($request->ajax()){
                $companies = $result['object']['companies'];
                $results =  view('User.partials.filter_companies_results')->with([
                    'companies'=>$companies,
                    'countCompanies'=>$result['object']['total'],
                    'brands'=>$result['object']['filterd_brands'],
                    'categories'=>$result['object']['filterd_categories'],
                    'areas'=>$result['object']['filterd_areas'],
                    'types'=>$result['object']['filterd_types'],
                ])->render();
                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                if(($pos = strpos($actual_link, "&")) !== FALSE){
                    $fullPath = substr($actual_link, strpos($actual_link, "&") );
                    if($companies->nextPageUrl() !=null)
                        $next = $companies->nextPageUrl().$fullPath;
                    else
                        $next=null;
                    if($companies->previousPageUrl() !=null)
                        $prev = $companies->previousPageUrl().$fullPath;
                    else
                        $prev = null;
                }else{
                    $next = $companies->nextPageUrl();
                    $prev = $companies->previousPageUrl();
                }
                return response()->json(['code' =>'200','result'=>$results,'next'=>$next,'prev'=>$prev,'actual_link'=>$actual_link]);
            }else{
                return view('User.companies_filter')->with([
                    'companies'=>$result['object']['companies'],
                    'countCompanies'=>$result['object']['total'],
                    'filterd_brands'=>$result['object']['filterd_brands'],
                    'filterd_categories'=>$result['object']['filterd_categories'],
                    'filterd_areas'=>$result['object']['filterd_areas'],
                    'filterd_types'=>$result['object']['filterd_types'],
                    'brands'=> $result['object']['brands'],
                    'areas' => $result['object']['areas'],
                    'types' => $result['object']['types'],
                    'categories' => $result['object']['categories'],
                    'keyword'=>$result['object']['keyword'],
                    'key'=>$result['object']['key'],
                    'category'=>$result['object']['category'],
                    'lang_changed' => $this->langChanged(),
                ]);
            }
        }else{
            if ($request->ajax())
                return response()->json(['code' =>'500','result'=>null,'next'=>null,'prev'=>null,'actual_link'=>null]);
            else
                abort(500);
        }
    }
    /**
     * Get All Products related to a company
     *
     * @param Request $request, $id, $name
     *
     * @return View
     */
    public function companyProducts(Request $request,$id,$name)
    {
        $request->merge(['in_company' => $id]);
        $this->productRepo->setReq($request);
        $result = $this->productRepo->getProducts();
        if($result['success']){
            $products = $result['object']['products'];
            $products_ids = $result['object']['products_ids'];
            $countProducts = $result['object']['total'];
            $company = $result['object']['company'];
            $countries = $result['object']['countries'];
            $categories = $result['object']['categories'];
            $brands = $result['object']['brands'];
            $lang_changed = $this->langChanged();
            return view('User.products_companies',compact('products','products_ids','countProducts','company','countries','categories','brands','lang_changed'));
        }else
            abort(500);
    }
    /**
     * Get companies based on category
     *
     * @param Request $request, $id, $name
     *
     * @return View
     */
	public function CompanyCategory(Request $request , $name,$id)
	{
        $request->merge(['in_category'=>$id]);
        $this->companyRepo->setReq($request);
        $result = $this->companyRepo->getCompanies();
        if($result['success']){
            $companies = $result['object']['companies'];
            $countCompanies = $result['object']['total'];
            $category = $result['object']['category'];
            $brands = $result['object']['brands'];
            $areas = $result['object']['areas'];
            $types = $result['object']['types'];
            $categories = $result['object']['categories'];
            $lang_changed = $this->langChanged();
            return view('User.companies',compact('companies','countCompanies','category','brands','areas','types','categories','lang_changed'));
        }else
            abort(500);
	}

    /**
     * Get Companies by Tag(Keyword)
     *
     * @param Request $request,$id
     *
     * @return View
     */
    public function CompanyKeywords(Request $request,$id)
    {
        $request->merge(['in_keyword'=>$request->input('tag')]);
        $this->companyRepo->setReq($request);
        $result = $this->companyRepo->getCompanies();
        if($result['success']){
            $companies = $result['object']['companies'];
            $countCompanies = $result['object']['total'];
            $keyword = $result['object']['keyword'];
            $brands = $result['object']['brands'];
            $areas = $result['object']['areas'];
            $types = $result['object']['types'];
            $categories = $result['object']['categories'];
            $lang_changed = $this->langChanged();
            return view('User.companies',compact('companies','countCompanies','keyword','brands','areas','types','categories','lang_changed'));
        }else
            abort(500);
    }
    /**
     * Store user info after call Company using Phone
     *
     * @param StoreCallbackRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function CallRequest(StoreCallbackRequest $request){
        $this->companyRepo->setReq($request);
        $result = $this->companyRepo->callByPhone();
        if($result['success'])
            return response()->json(['status'=>200,'success' => $result['success']]);
        else
            return response()->json(['status'=>500,'error' => 'Error occured, Please try agin later.']);
    }
    /**
     * Store user info after call Company using Phone
     *
     * @param StoreCallbackRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function whatsCallRequest(StoreCallbackRequest $request){
        $this->companyRepo->setReq($request);
        $result = $this->companyRepo->connectByWhatsapp();
        if($result['success'])
            return response()->json(['status'=>200,'success' => $result['success']]);
        else
            return response()->json(['status'=>500,'error' => 'Error occured, Please try agin later.']);
    }
    /**
     * Request General quotaion
     *
     * @param StoreGeneralQuotaionRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestGeneralQuotaion(StoreGeneralQuotaionRequest $request){
        $this->companyRepo->setReq($request);
        $result = $this->companyRepo->requestGeneralQuotation();
        if($result['success'])
            return response()->json(['status'=>200,'success' =>$result['success']]);
        else
            return response()->json(['status'=>500,'error' => 'Error occured, Please try agin later.']);
    }
    /**
     * Store uer info after click on View more info or Download PDF buttons
     *
     * @param StoreBtnClickRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function BtnClick(StoreBtnClickRequest $request){
        $this->companyRepo->setReq($request);
        if ($request->input('click')=='more_info') {
            $result = $this->companyRepo->viewMoreInfo();
            if($result['success'])
                return response()->json(['status'=>200,'success' =>$result['success']]);
            else
                return response()->json(['status'=>500,'error' => 'Error occured, Please try agin later.']);
        }
        else{
            $result = $this->companyRepo->downloadPDF();
            if($result['success'])
                return response()->json(['status'=>200,'success' =>$result['success']]);
            else
                return response()->json(['status'=>500,'error' => 'Error occured, Please try agin later.']);
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
