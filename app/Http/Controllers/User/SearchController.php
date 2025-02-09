<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\SearchRequest;
use App\Repository\User\ProductRepo;
use App\Repository\User\CompanyRepo;
use App\Repository\User\BrandRepo;
class SearchController extends Controller
{
    protected $productRepo;
    protected $companyRepo;
    protected $brandRepo;

    public function __construct(ProductRepo $productRepo,CompanyRepo $companyRepo,BrandRepo $brandRepo)
    {
        $this->productRepo = $productRepo;
        $this->companyRepo = $companyRepo;
        $this->brandRepo   = $brandRepo;
    }

    /**
     * Search in  brands or product or companies
     *
     * @param SearchRequest $request
     *
     * @return colloection of data
     */
	public function search(SearchRequest $request)
	{

		if ($request->search_type == 'products') {
            $this->productRepo->setReq($request);
            $result = $this->productRepo->getProducts();
            if($result['success']){
                $products       = $result['object']['products'];
                $products_ids   = $result['object']['products_ids'];
                $countProducts  = $result['object']['total'];
                $countries      = $result['object']['countries'];
                $categories     = $result['object']['categories'];
                $companies      = $result['object']['companies'];
                $brands         = $result['object']['brands'];
                // $specifications = $result['object']['specifications'];
                $lang_changed = $this->langChanged();
                return view('User.products_search',compact('products','products_ids','countProducts','countries','categories','companies','brands','lang_changed'));
            }else
                abort(500);
		}
		elseif ($request->search_type == 'brands') {
            $this->brandRepo->setReq($request);
            $result = $this->brandRepo->getBrands();
            if($result['success']){
                $brands       = $result['object']['brands'];
                $countBrands  = $result['object']['total'];
                $countries      = $result['object']['countries'];
                $categories     = $result['object']['categories'];
                $companies      = $result['object']['companies'];
                $lang_changed = $this->langChanged();
                return view('User.brands_search',compact('brands','countBrands','countries','categories','companies','lang_changed'));
            }else
                abort(500);
		}
		elseif ($request->search_type == 'companies') {
            $this->companyRepo->setReq($request);
            $result = $this->companyRepo->getCompanies();
            if($result['success']){
                $companies       = $result['object']['companies'];
                $countCompanies  = $result['object']['total'];
                $brands          = $result['object']['brands'];
                $areas           = $result['object']['areas'];
                $types           = $result['object']['types'];
                $categories     = $result['object']['categories'];
                $lang_changed = $this->langChanged();
                return view('User.companies_search',compact('companies','countCompanies','brands','areas','types','categories','lang_changed'));
            }else
                abort(500);

		}
		else
			return back();
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
