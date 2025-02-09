<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyAdmin;
use App\Models\CompanyProduct;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\GeneralRfq;
use App\Models\ViewInformation;
use App\Models\CallbackRequest;
use App\Models\PdfDownload;
use App\Models\ProductRfq;
use App\Models\CompanySubscription;
use Hash;
use Auth;
class CompanyAuthenticationController extends Controller
{
	/**
     * Display a form of login of Company Portal.
     */
     public function login()
    {

		if (Auth::guard('company')->check()) {
			return redirect()->route('company.home');
		}
		return view('User.auth.login');
	}
	/**
     * Displaing a dashboard page.
     */
	public function home()
	{
		if (!Auth::guard('company')->check()) {
			return redirect()->route('company.login');
		}
		return view('Company.home');
	}
	/**
     * check user login data.
     */
	public function checkLogin(Request $request)
	{
		$admin = CompanyAdmin::where('email',$request->email)->first();
		if ($admin)
		{
			if(Hash::check($request->password, $admin->password)) {
				if(auth()->guard('company')->loginUsingId($admin->company_id))
				{
					return redirect()->route('company.home');
				}

			}
			else{
				session()->flash('error',"Email and password dosn't match our records ");
				return redirect()->route('company.login');
			}
	    }
		$remember = request('rememberme') == 1 ? true: false;
		if(auth()->guard('company')->attempt(['pri_contact_email'=>request('email'),'password'=>request('password')],$remember)){
			return redirect()->route('company.home');
		}
		else{
			session()->flash('error',"Email and password dosn't match ");
			return redirect()->route('company.login');
		}
	}
	/**
     * logout company portal user.
     */
	public function logout()
	{
		auth()->guard('company')->logout();
		return redirect()->route('company.login');
	}
}
