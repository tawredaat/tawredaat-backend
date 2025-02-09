<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Brand;
use App\Models\CompanyProduct;
use App\Models\Product;
use App\Models\Category;
class DashboardController extends Controller
{
	public function brand(){
    	$title = 'Brands';
        $company_id      = auth('company')->user()->id;
        $brands          = CompanyProduct::with('brand')->where('company_id',$company_id)->groupBy('brand_id')->get();
        // $brands          = Brand::whereIn('id',$brands_ids)->get();
    	return view('Company._dashboard.brands',compact('title','brands'));
    }

    public function category(){
    	$title = 'Categories';
                $company_id      = auth('company')->user()->id;
        $products_ids     = CompanyProduct::where('company_id',$company_id)->pluck('product_id');
        $products         = Product::whereIn('id',$products_ids)->pluck('category_id');
        $categories       = Category::where('level','level3')->whereIn('id',$products)->get();
    	return view('Company._dashboard.categories',compact('title','categories'));
    }

}
