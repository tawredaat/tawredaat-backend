<?php

namespace App\Repository\User;

use App\Actions\User\Cart\ApplyPromoCodeGuestUserAction;
use App\Actions\User\Cart\UpdateCartWithPromoCodeId;
use App\Helpers\General;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Promocode;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestCartRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }
    /**
     * View Cart items.
     *
     * @return colloection of data
     */
    public function view($guest_user)
    {
        DB::beginTransaction();
        try {
            $cart = Cart::with('items.shopProduct')
                ->where('guest_user_id', $guest_user->id)->first();
            if (!$cart) {
                return $this->result = ['validator' => [__('home.userHasNoCart')], 'success' => null, 'errors' => null, 'object' => null];
            }

            $results['cart'] = new CartResource($cart, $guest_user);
            return $this->result = ['validator' => null, 'success' => 'User Cart', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    /**
     * Store cart item instance in DB for guest user, if this is a first item we create instance of cart in DB.
     *
     * @return colloection of data
     */
    public function store($guest_user)
    {
        $request = $this->request;

        DB::beginTransaction();
        try {
            $product = ShopProduct::whereNotNull('image')
                ->where('id', $this->request->input('shopProductId'))->first();
            if (!$product) {
                return $this->result = ['validator' => [__('home.cartItemNotFound')],
                    'success' => null, 'errors' => null, 'object' => null];
            }

            $cart = Cart::where('guest_user_id', $guest_user->id)->first();
            if (!$cart) {
                $cart = Cart::create(['guest_user_id' => $guest_user->id]);
            }

            if (CartItem::where('cart_id', $cart->id)->where('shop_product_id', $product->id)->count()) {
                return $this->result = ['validator' => [__('home.cartItemExist')], 'success' => null, 'errors' => null, 'object' => null];
            }

            if ((int) $this->request->input('quantity') < 1) {
                return ['validator' => [__('home.InvalidQuantity')], 'success' => null, 'errors' => null, 'object' => null];
            }

            $cart_item = CartItem::create(
                [
                    'cart_id' => $cart->id,
                    'shop_product_id' => $product->id,
                    'qty' => $this->request->input('quantity'),
                ]);

            DB::commit();

            $results['cart'] = new CartResource($cart, $guest_user);
            $results['cart_item_id'] = $cart_item->id;
            return $this->result = ['validator' => null, 'success' => __('home.cartItemAdded'), 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    /**
     * Store Cart item instance in DB, if this is a first item we create instance of cart in DB.
     *
     * @return colloection of data
     */
    public function update($guest_user)
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            $cart_item = CartItem::with('shopProduct')
                ->where('id', $this->request->cartItemId)->whereIn('cart_id', Cart::where('guest_user_id', $guest_user->id)->pluck('id'))->first();
            if (!$cart_item) {
                return $this->result = ['validator' => [__('home.itemNotFound')], 'success' => null, 'errors' => null, 'object' => null];
            }

            //if increment 0 or 1, guest_user update quantity of item  in cart
            if ($request->input('increment') < 2) {
                $quantitiesArr = General::CreateProductInterval(1, $cart_item->shopProduct->qty, 1);
                // Check if this item is in offer to update the quantity
                $newQuantity = $this->request->input('increment') ? $cart_item->qty + 1 : $cart_item->qty - 1;
                if ($newQuantity < 1) {
                    return ['validator' => [__('home.InvalidQuantity')], 'success' => null, 'errors' => null, 'object' => null];
                }

                // if (in_array($newQuantity, $quantitiesArr)) {
                $cart_item->qty = $newQuantity;
                $cart_item->save();
                DB::commit();
                $results['cartItem'] = new CartItemResource($cart_item, $guest_user);
                $cart = json_decode(json_encode(new CartResource($guest_user->cart, $guest_user)));
                $results['totalAmount'] = $cart ? round($cart->itemsTotal, 2) : 0;
                return $this->result = ['validator' => null, 'success' => __('home.cartItemUpdated'), 'errors' => null, 'object' => $results];
                // } else
                //     return ['validator' => [__('home.InvalidQuantity')], 'success' => null, 'errors' => null, 'object'=>null];
            }
            return ['validator' => ['The increment field is required.'], 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    /**
     * Delete Cart item instance from DB, if this is a last item we remove this instance from cart in DB.
     *
     * @return colloection of data
     */
    public function delete($guest_user, $id)
    {
        DB::beginTransaction();
        try {
            $cart_item = CartItem::with(['shopProduct', 'cart'])
                ->where('id', $id)->whereIn('cart_id', Cart::where('guest_user_id', $guest_user->id)
                    ->pluck('id'))->first();
            if ($cart_item) {
                if ($cart_item->cart->items->count() == 1) {
                    $cart_item->cart->delete();
                } else {
                    $cart_item->delete();
                }

                DB::commit();
                $results['itemsCount'] = $guest_user->cart ? count($guest_user->cart->items) : 0;
                $cart = $guest_user->cart ? json_decode(json_encode(new CartResource($guest_user->cart, $guest_user))) : null;
                $results['totalAmount'] = $cart ? round($cart->itemsTotal, 2) : 0;
                return $this->result = ['validator' => null, 'success' => __('home.cartItemDeleted'), 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => [__('home.itemNotFound')], 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    /**
     * Apply promo code on cart
     */
    public function applyPromoCode($guest_user, $code,
        ApplyPromoCodeGuestUserAction $apply_promo_code_action,
        UpdateCartWithPromoCodeId $update_cart_with_promo_codeId) {

        DB::beginTransaction();
        try {
            // find cart
            $cart = Cart::with('items')->where('guest_user_id', $guest_user->id)->first();
            if (is_null($cart)) {
                return $this->result = ['validator' => [__('home.userHasNoCart')], 'success' => null, 'errors' => null, 'object' => null];
            }

            $promo_code = Promocode::where('code', $code)->select('id')->first();

            $results = $apply_promo_code_action->execute($promo_code->id, $cart);
            $update_cart_with_promo_codeId->execute($promo_code->id, $cart);
            DB::commit();
            return $this->result = ['validator' => null,
                'success' => __('home.promo_code_applied_successfully'),
                'errors' => null, 'object' => $results];

        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    /**
     * Delete Cart instance of a user from DB.
     *
     * @return colloection of data
     */
    function empty($guest_user) {
        DB::beginTransaction();
        try {
            $cart = Cart::with('items')->where('guest_user_id', $guest_user->id)->first();
            if ($cart) {
                $cart->delete();
                DB::commit();
                return $this->result = ['validator' => null, 'success' => __('home.cartEmpty'), 'errors' => null, 'object' => null];
            }
            return $this->result = ['validator' => [__('home.userHasNoCart')], 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
}
