<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Repository\User\OrderRepo;
use App\Models\Order;
class OrderController extends Controller
{

    protected $orderRepo;


    public function __construct(OrderRepo $orderRepo)
    {
        $this->orderRepo  = $orderRepo;
    }
    /**
     * View User orders
     * @return View
     */
    public function view()
    {
        $result = $this->orderRepo->view(auth('web')->user());
        if($result['success']){
            $orders = json_decode(json_encode($result['object']['orders']));
            $lang_changed = $this->langChanged();
            return view('User.orders')->with(['orders'=>$orders,'lang_changed'=>$lang_changed]);
        }
        else
            abort(500);
    }
    /**
     * View  order details
     * @return View
     */
    public function show(Order $order)
    {
        $result = $this->orderRepo->show(auth('web')->user(),$order);
        if($result['success']){
            $order = json_decode(json_encode($result['object']['order']));
            $lang_changed = $this->langChanged();
            return view('User.order')->with(['order'=>$order,'lang_changed'=>$lang_changed]);
        }
        else
            abort(404);
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

