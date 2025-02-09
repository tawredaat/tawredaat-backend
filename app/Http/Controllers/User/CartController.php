<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Repository\User\CartRepo;
use App\Models\ShopProduct;
use App\Http\Resources\ShopProductResource;
use App\Http\Requests\User\StoreCartItemRequest;
use App\Http\Requests\User\UpdateCartItemRequest;
use Illuminate\Support\Facades\Cookie;
class CartController extends Controller
{

    protected $cartRepo;

    public function __construct(CartRepo $cartRepo)
    {
        $this->cartRepo  = $cartRepo;
    }
    /**
     * View User Shop Cart
     * @param Request $request
     * @return View
     */
    public function view(Request $request)
    {
        $this->cartRepo->setReq($request);
        if(auth('web')->check())
        {
            $result = $this->cartRepo->view(auth('web')->user());
            if($result['success']){
                $cart  = json_decode(json_encode($result['object']['cart']));
                return view('User.cart')->with(['cart'=>$cart]);
            }
            return view('User.cart')->with(['cart'=>null]);
        }
        $cart = [];
        if(Cookie::get('shopping_cart')){
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart = json_decode($cookie_data, true);
            $item_ids = array_column($cart, 'item_id');
            $items = ShopProduct::find($item_ids);
            $items_collection = [];
            foreach($items as $item){
                if(!in_array(json_decode(json_encode(new ShopProductResource($item))), $items_collection))
                    array_push($items_collection,json_decode(json_encode(new ShopProductResource($item))));
            }
            $cart = $items_collection;
        }
        return view('User.cart_for_guest')->with(['cart'=>$cart]);
    }
    /**
     * Add shop Products to cart
     * @param Request $request
     * @return View
     */
    public function store(StoreCartItemRequest $request)
    {
        $this->cartRepo->setReq($request);
        $result = $this->cartRepo->store(auth('web')->user());
        if($result['success']){
            return response()->json([
                'code' =>'200',
                'message'=>$result['success'],
                'shopProduct'=>$request->input('shopProductId'),
                'cartCount'=>auth('web')->user()->items->count(),
                'action'=> view('User.partials.cart_component')->with([
                    'product' => json_decode(json_encode(new ShopProductResource(ShopProduct::find($request->input('shopProductId')),auth('web')->user()))),
                ])->render(),
                'shop_product_single_page'=>view('User.partials.cart_component_for_single_item')->with([
                    'product' => json_decode(json_encode(new ShopProductResource(ShopProduct::find($request->input('shopProductId')),auth('web')->user()))),
                ])->render(),

            ]);
        }
        elseif($result['validator']){
            return response()->json([
                'code' =>'101',
                'message'=>$result['validator'][0],
                'shopProduct'=>$request->input('shopProductId'),

            ]);
        }
        else
            return response()->json(['code' =>'500','result'=>null]);
    }

    /**
     * update shop Products qtys in cart
     * @param Request $request
     * @return View
     */
    public function update(UpdateCartItemRequest $request)
    {
        $this->cartRepo->setReq($request);
        $result = $this->cartRepo->update(auth('web')->user());
        if($result['success']){
            $item = json_decode(json_encode($result['object']['cartItem']));
            $totalAmount = $result['object']['totalAmount'];
            return response()->json([
                'code' =>'200',
                'message'=>$result['success'],
                'amount'=>$item->amount,
                'item'=>$item->id,
                'cartTotal'=>__('home.total') .': <span>'.round($totalAmount,2).''.__('home.currency').'</span>',
                'shopProduct'=>$request->input('shopProductId'),
                'action'=> view('User.partials.cart_component')->with([
                    'product' => json_decode(json_encode(new ShopProductResource(ShopProduct::find($request->input('shopProductId')),auth('web')->user()))),
                ])->render(),
            ]);
        }
        elseif($result['validator']){
            return response()->json([
                'code' =>'101',
                'message'=>$result['validator'][0],
                'shopProduct'=>$request->input('shopProductId')
            ]);
        }
        else
            return response()->json(['code' =>'500','result'=>null]);
    }
        /**
     * delete shop Products from cart
     * @param Request $request
     * @return View
     */
    public function delete(Request $request)
    {
        $this->cartRepo->setReq($request);
        $result = $this->cartRepo->delete(auth('web')->user(),$request->input('cartItemId'));
        $cart = $this->cartRepo->view(auth('web')->user());
        if($result['success']){
            $itemsTotal  = $result['object']['totalAmount'];
            $itemsCount  = $result['object']['itemsCount'];
            return response()->json([
                'code' =>'200',
                'message'=>$result['success'],
                'cartCount'=> $itemsCount,
                'cartTotal'=>__('home.total') .': <span>'.$itemsTotal.''.__('home.currency').'</span>',
                'shopProduct'=>$request->input('shopProductId'),
                'action'=> view('User.partials.cart_component')->with([
                    'product' => json_decode(json_encode(new ShopProductResource(ShopProduct::find($request->input('shopProductId')),auth('web')->user()))),
                ])->render(),
                'shop_product_single_page'=>view('User.partials.cart_component_for_single_item')->with([
                    'product' => json_decode(json_encode(new ShopProductResource(ShopProduct::find($request->input('shopProductId')),auth('web')->user()))),
                ])->render(),
            ]);
        }
        elseif($result['validator']){
            return response()->json([
                'code' =>'101',
                'message'=>$result['validator'][0],
                'shopProduct'=>$request->input('shopProductId')
            ]);
        }
        else
            return response()->json(['code' =>'500','result'=>null]);
    }
}

