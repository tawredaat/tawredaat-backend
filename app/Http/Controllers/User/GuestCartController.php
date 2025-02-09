<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\ShopProduct;
use App\Http\Resources\ShopProductResource;
use App\Http\Requests\User\StoreCartItemRequest;
use App\Http\Requests\User\UpdateCartItemRequest;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\General;
class GuestCartController extends Controller
{

    /**
     * Add shop Products to guest cart
     * @param Request $request
     * @return View
     */
    public function store(StoreCartItemRequest $request)
    {
        $cart = [];
        if(Cookie::get('shopping_cart')){
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart = json_decode($cookie_data, true);
        }
        if(is_array($cart) && in_array($request->input('shopProductId'), array_column($cart, 'item_id')))
            return response()->json([
                'code' =>'101',
                'message'=>__('home.cartItemExist'),
                'shopProduct'=>$request->input('shopProductId'),
            ]);
        else
        {
            $item = ShopProduct::find($request->input('shopProductId'));
            $item_array = array(
                'item_id' => $request->input('shopProductId'),
                'item_quantity' => $request->input('quantity'),
                'item_price' => $item->new_price,
                'item_store_qty' => $item->qty,
            );
            //push item to cart
            $cart[] = $item_array;
            $item_data = json_encode($cart);
            Cookie::queue(Cookie::make('shopping_cart', json_encode($cart), 60));
            $product = json_decode(json_encode(new ShopProductResource($item, null, $cart )));
            return response()->json([
                'code' =>'200',
                'message'=>__('home.cartItemAdded'),
                'shopProduct'=>$request->input('shopProductId'),
                'cartCount'=>count($cart),
                'action'=> view('User.partials.cart_component_for_guest')->with([
                    'product' =>$product ,
                ])->render(),
                'shop_product_single_page'=>view('User.partials.cart_component_for_single_item_for_guest')->with([
                    'product' => $product,
                ])->render(),
            ]);
        }
    }

    /**
     * update shop Products qtys in guest cart
     * @param Request $request
     * @return View
     */
    public function update(Request $request)
    {

        $cart = [];
        $itemsTotal = 0;
        $newQuantity = 0;
        if(Cookie::get('shopping_cart')){
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart = json_decode($cookie_data, true);
        }
        if(is_array($cart) && in_array($request->input('shopProductId'), array_column($cart, 'item_id')))
        {

            foreach($cart as $key=>$value)
            {
                $itemsTotal += ($cart[$key]["item_quantity"]*$cart[$key]["item_price"]);
                if($cart[$key]["item_id"] == $request->input('shopProductId'))
                    $updated_key = $key;
            }
            if(isset($updated_key)){
                $itemsTotal -= ($cart[$updated_key]["item_quantity"]*$cart[$updated_key]["item_price"]);
                $quantitiesArr = General::CreateProductInterval(1, (int)$cart[$updated_key]['item_store_qty'], 1);
                $newQuantity = $request->input('increment') ? $cart[$updated_key]["item_quantity"] + 1 : $cart[$updated_key]["item_quantity"] - 1;
                $itemsTotal += ($newQuantity*$cart[$updated_key]["item_price"]);
                //if increment 0 or 1, user update quantity of item  in cart
                if($request->input('increment') < 2 && in_array($newQuantity, $quantitiesArr)) {
                        $cart[$updated_key]["item_quantity"] = $newQuantity;
                        Cookie::queue(Cookie::make('shopping_cart', json_encode($cart), 60));
                        return response()->json([
                            'code' =>'200',
                            'message'=>__('home.cartItemUpdated'),
                            'amount'=>$newQuantity*$cart[$updated_key]["item_price"],
                            'item'=>$request->input('shopProductId'),
                            'cartTotal'=>__('home.total') .': <span>'.$itemsTotal.''.__('home.currency').'</span>',
                            'shopProduct'=>$request->input('shopProductId'),
                            'action'=> view('User.partials.cart_component_for_guest')->with([
                                'product' => json_decode(json_encode(new ShopProductResource(ShopProduct::find($request->input('shopProductId')),null,$cart))),
                            ])->render(),
                        ]);
                }
                return response()->json([
                    'code' =>'101',
                    'message'=>'Invalid quantity',
                    'shopProduct'=>$request->input('shopProductId'),
                ]);
            }else
                return response()->json([
                    'code' =>'101',
                    'message'=>__('home.itemNotFound'),
                    'shopProduct'=>$request->input('shopProductId'),
                ]);
        }
        else
            return response()->json([
                'code' =>'101',
                'message'=>__('home.itemNotFound'),
                'shopProduct'=>$request->input('shopProductId'),
            ]);
    }
    /**
     * delete shop Products from guest cart
     * @param Request $request
     * @return View
     */
    public function delete(Request $request)
    {
        $cart = [];
        $itemsTotal = 0;
        if(Cookie::get('shopping_cart')){
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart = json_decode($cookie_data, true);
        }
        if(is_array($cart) && in_array($request->input('shopProductId'), array_column($cart, 'item_id')))
        {
            foreach($cart as $key=>$value)
            {
                if($cart[$key]["item_id"] != $request->input('shopProductId'))
                    $itemsTotal += $cart[$key]["item_quantity"]*$cart[$key]["item_price"];
                if($cart[$key]["item_id"] == $request->input('shopProductId'))
                    unset($cart[$key]);

            }
            Cookie::queue(Cookie::make('shopping_cart', json_encode($cart), 60));
            if(!count($cart)){
                Cookie::forget('shopping_cart');
            }
            return response()->json([
                'code' =>'200',
                'message'=>__('home.cartItemDeleted'),
                'cartCount'=> count($cart),
                'cartTotal'=>__('home.total') .': <span>'.$itemsTotal.''.__('home.currency').'</span>',
                'shopProduct'=>$request->input('shopProductId'),
                'action'=> view('User.partials.cart_component_for_guest')->with([
                    'product' => json_decode(json_encode(new ShopProductResource(ShopProduct::find($request->input('shopProductId')), null,$cart ))),
                ])->render(),
                'shop_product_single_page'=>view('User.partials.cart_component_for_single_item_for_guest')->with([
                    'product' =>json_decode(json_encode(new ShopProductResource(ShopProduct::find($request->input('shopProductId')), null,$cart ))),
                ])->render(),
            ]);
        }
        else
            return response()->json([
                'code' =>'101',
                'message'=>__('home.itemNotFound'),
                'shopProduct'=>$request->input('shopProductId'),
            ]);

    }
}

