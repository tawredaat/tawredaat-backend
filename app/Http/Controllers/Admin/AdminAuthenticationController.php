<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Company;
use App\Models\Unit;
use App\Models\Area;
use App\Models\Country;
use App\Models\Category;
use App\Models\Promocode;
use App\Models\Advertising;
use App\Models\Brand;
use App\Models\Order;
use Carbon\Carbon;

class AdminAuthenticationController extends Controller
{
    public function login()
    {
    	if (Auth::guard('admin')->check())
			return back();
		return view('Admin.auth.login');
	}
	public function home()
	{
      	$currentMonth = Carbon::now()->month;
		$currentYear = Carbon::now()->year;
      
      	$gross_orders_count = Order::count();
      	$gross_order_total = intval(Order::sum('total'));
      
        $current_month_gross_orders_count = Order::whereYear('created_at', $currentYear)
                              ->whereMonth('created_at', $currentMonth)
                              ->count();

        $current_month_gross_order_total = intval(Order::whereYear('created_at', $currentYear)
                                         ->whereMonth('created_at', $currentMonth)
                                         ->sum('total'));
      
        $deliverd_orders_count = Order::where('order_status_id',4)->count();
        $deliverd_orders_total = intval(Order::where('order_status_id',4)->sum('total'));
      
      	$current_month_delivered_orders_count = Order::where('order_status_id', 4)
                                ->whereYear('created_at', $currentYear)
                                ->whereMonth('created_at', $currentMonth)
                                ->count();

        $current_month_delivered_orders_total = intval(Order::where('order_status_id', 4)
                                              ->whereYear('created_at', $currentYear)
                                              ->whereMonth('created_at', $currentMonth)
                                              ->sum('total'));
      
     	$cancelled_orders_count = Order::where('order_status_id' , 8)->count();
        $cancelled_orders_total = intval(Order::where('order_status_id',8)->sum('total'));
      
        $current_month__cancelled_orders_count = Order::where('order_status_id', 8)
                                  ->whereYear('created_at', $currentYear)
                                          ->whereMonth('created_at', $currentMonth)
                                          ->count();

        $current_month_cancelled_orders_total = intval(Order::where('order_status_id', 8)
                                              ->whereYear('created_at', $currentYear)
                                              ->whereMonth('created_at', $currentMonth)
                                              ->sum('total'));
      
		return view('Admin.home',compact('gross_orders_count','gross_order_total','cancelled_orders_count','cancelled_orders_total','deliverd_orders_count','deliverd_orders_total' , 'current_month_gross_orders_count' , 'current_month_gross_order_total','current_month_delivered_orders_count' , 'current_month_delivered_orders_total' , 'current_month__cancelled_orders_count' , 'current_month_cancelled_orders_total'));
	}

	public function checkLogin()
	{
		$remember = request('rememberme') == 1 ? true: false;
		if(auth()->guard('admin')->attempt(['email'=>request('email'),'password'=>request('password')],$remember)){
			return redirect('admin');
		}else{
			session()->flash('error',"Email and password dosn't match ");
			return redirect('admin/login');
		}
	}
	public function logout()
	{
		auth()->guard('admin')->logout();
		return redirect('admin/login');
	}
}
