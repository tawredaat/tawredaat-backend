<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Company\UpdateBrandTypeRequest;
use Yajra\Datatables\Datatables;
use App\Models\Brand;
use App\Models\CompanyProduct;
use App\Models\CompanyType;
use App\Models\CompanyBrand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
class BrandController extends Controller
{
	public function index(){
    	$title = 'Brands';
        $company_id      = auth('company')->user()->id;
        $brands          = CompanyProduct::with('brand')->where('company_id',$company_id)->groupBy('brand_id')->get();
        $companyTypes = CompanyType::all();
    	return view('Company._brands.index',compact('title','brands','companyTypes'));
    }
	public function assign(){
    	$title = 'Brands';
        $company_id      = auth('company')->user()->id;
        $brands          = CompanyProduct::with('brand')->where('company_id',$company_id)->groupBy('brand_id')->get();
        $companyTypes = CompanyType::all();
        $brands = Brand::whereNotIn('id',$brands->pluck('brand_id')->toArray())->get();
    	return view('Company._brands.assign',compact('title','brands','companyTypes'));
    }

    public function update(UpdateBrandTypeRequest $request){
    	DB::beginTransaction();
        try {
            $company = auth('company')->user()->id;
        	$brandsCompanies =CompanyProduct::where('brand_id',$request->id)->where('company_id',$company)->get();
            CompanyBrand::where('brand_id',$request->id)->where('company_id',$company)->delete();
            foreach ($request->company_type_id as $type_id){
                CompanyBrand::create(['company_id'=>$company,'brand_id'=>$request->id,'company_type_id'=>$type_id]);            
            }
            if(count($brandsCompanies)){
                foreach ($brandsCompanies as $brand) {
                    $brand->approve =1;
                    $brand->save();
                }
            }else
                CompanyProduct::create(['company_id'=>$company,'brand_id'=>$request->id,'approve'=>1]);
    	DB::commit();
        session()->flash('_added','Data saved successfully');
        return redirect()->route('company.view.brands');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    public function unassign($id)
    {
        DB::beginTransaction();
        try {
            CompanyProduct::where('brand_id',$id)->where('company_id',auth('company')->user()->id)->delete();
            CompanyBrand::where('brand_id',$id)->where('company_id',auth('company')->user()->id)->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted','id'=>$id]);
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
}
