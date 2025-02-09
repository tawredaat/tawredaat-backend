<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Repository\User\CheckoutRepo;
use App\Repository\User\CartRepo;
use App\Repository\User\UserRepo;
use App\Http\Requests\User\SelectPaymentRequest;
use App\Http\Requests\User\SelectAddressRequest;
use App\Http\Requests\User\StoreUserAddressRequest;
class CheckoutController extends Controller
{

    protected $checkOutRepo;
    protected $cartRepo;
    protected $userRepo;


    public function __construct(CheckoutRepo $checkOutRepo,CartRepo $cartRepo,UserRepo $userRepo)
    {
        $this->checkOutRepo  = $checkOutRepo;
        $this->cartRepo  = $cartRepo;
        $this->userRepo  = $userRepo;
    }
    /**
     * View User Checkout
     * @param Request $request
     * @return View
     */
    public function view(Request $request)
    {
        $this->checkOutRepo->setReq($request);
        $result = $this->checkOutRepo->payments();
        if($result['success']){
            $cart = $this->cartRepo->view(auth('web')->user());
            if($cart['success']){
                $cart  = json_decode(json_encode($cart['object']['cart']));
                if(!$cart->address)
                    return redirect()->route('user.view.addresses');
                $payments  = json_decode(json_encode($result['object']['payments']));
                return view('User.checkout')->with(['payments'=>$payments,'cart'=>$cart]);
            }
            return redirect()->route('user.home')->with('error','You must add products in cart !');
        }
        else
            abort(500);
    }
    /**
     * View User addresses
     * @return View
     */
    public function addresses()
    {
        $result = $this->userRepo->viewAddresses(auth('web')->user());
        if($result['success']){
            $countries = \App\Models\City::all()->sortBy('name');
            $cart = $this->cartRepo->view(auth('web')->user());
            if($cart['success']){
                $cart  = json_decode(json_encode($cart['object']['cart']));
                $addresses  = json_decode(json_encode($result['object']['addresses']));
                return view('User.selectAddress')->with(['addresses'=>$addresses,'cart'=>$cart,'countries'=>$countries]);
            }
            return redirect()->route('user.home')->with('error','You must add products in cart !');
        }
        else
            abort(500);

    }
    /**
     * Select User Address
     * @param SelectAddressRequest $request
     * @return View
     */
    public function selectAddress(SelectAddressRequest $request)
    {
        $this->checkOutRepo->setReq($request);
        $result = $this->checkOutRepo->selectAddress(auth('web')->user());
        if($result['success'])
            return response()->json([
                'code' =>'200',
                'message'=>$result['success'],
            ]);
        elseif($result['validator'])
            return response()->json([
                'code' =>'101',
                'message'=>$result['validator'][0],
            ]);
        else
            return response()->json(['code' =>'500','result'=>null]);
    }
     /**
     * Add User Address
     * @param StoreUserAddressRequest $request
     * @return View
     */
    public function addAddress(StoreUserAddressRequest $request)
    {
        $this->userRepo->setReq($request);
        $result = $this->userRepo->addAddress(auth('web')->user());
        if($result['success'])
            return back()->with([
                'success'=>$result['success'],
            ]);
        elseif($result['validator'])
            return back()->with([
                'error'=>$result['validator'][0],
            ]);
        else
            abort(500);
    }
    /**
     * Select User payment
     * @param SelectPaymentRequest $request
     * @return View
     */
    public function selectPayment(SelectPaymentRequest $request)
    {
        $this->checkOutRepo->setReq($request);
        $result = $this->checkOutRepo->selectPayment(auth('web')->user());
        if($result['success'])
            return response()->json([
                'code' =>'200',
                'message'=>$result['success'],
            ]);
        elseif($result['validator'])
            return response()->json([
                'code' =>'101',
                'message'=>$result['validator'],
            ]);
        else
            return response()->json(['code' =>'500','result'=>null]);
    }

    /**
     * Request Order/Save Checkout
     * @param Request $request
     * @return View
     */
    public function checkout(Request $request)
    {
        if(!auth('web')->user()->cart)
            return redirect()->route('user.home');
        $this->checkOutRepo->setReq($request);
        $result = $this->checkOutRepo->checkout(auth('web')->user());
        if($result['success'])
            return view('User.orderPlaced');
        elseif($result['validator'])
            return redirect()->route('user.home')->with([
                'error'=>$result['validator'][0],
            ]);
        else
            abort(500);
    }
}

