<?php

namespace App\Repository\User;

use App\Actions\User\Cart\ApplyPromoCodeAction;
use App\Actions\User\Cart\UpdateAddressWithDefaultAction;
use App\Actions\User\Cart\UpdateCartWithPromoCodeId;
use App\Helpers\General;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Promocode;
use App\Models\ShopProduct;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartRepo
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
    public function view($user)
    {
        DB::beginTransaction();
        try {
            $cart = Cart::with('items.shopProduct')->where('user_id', $user->id)->first();
            if (!$cart) {
                return $this->result = ['validator' => [__('home.userHasNoCart')], 'success' => null, 'errors' => null, 'object' => null];
            }

            $results['cart'] = new CartResource($cart, $user);
            return $this->result = ['validator' => null, 'success' => 'User Cart', 'errors' => null, 'object' => $results];
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
    public function store(
        $user,
        UpdateAddressWithDefaultAction $update_address_with_default_action,
        $request
    ) {
        DB::beginTransaction();
        try {
            $validationErrors = [];
    
            // Check if order items are present
            if (count($request['orderItems']) <= 0) {
                $validationErrors[] = __('home.cartItemNotFound');
            } else {
                foreach ($request['orderItems'] as $item) {
                    $product = ShopProduct::whereNotNull('image')
                        ->where('id', $item['shopProductId'])
                        ->first();
    
                    if (!$product) {
                        $validationErrors[] = __('home.cartItemNotFound');
                        continue;
                    }
    
                    if ($product->show !== 1) {
                        $validationErrors[] = $product->name .'-'.__('home.inavaliable');
                        continue;
                    }
    
                    if ($item['quantity'] > $product->qty) {
                        $validationErrors[] = $product->name . ' - ' . __('home.outOfStock') . ': ' . $product->qty;
                        continue;
                    }
    
                    if ((int) $item['quantity'] < 1) {
                        $validationErrors[] = __('home.InvalidQuantity');
                        continue;
                    }
    
                    $cart = Cart::where('user_id', $user->id)->first();
    
                    if (!$cart) {
                        $cart = Cart::create(['user_id' => $user->id, 'payment_id' => $request['payment_id']]);
                    }
                    $cart->promocode_id = $request['promocode_id'] ?? null;
                    $cart->payment_id = $request['payment_id'];
                    $cart->user_address_id = $request['address_id'];
                    $cart->save();
    
                    $itemBundleId = $item['bundelId'] !== null ? $item['bundelId'] : null;
                    if (
                        CartItem::where('cart_id', $cart->id)
                            ->where('shop_product_id', $product->id)
                            ->where(['bundel_id' => $itemBundleId])
                            ->exists()
                    ) {
                        $validationErrors[] = $product->name .'-'. __('home.cartItemExist');
                        continue;
                    }
                    // Create the cart item
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'shop_product_id' => $product->id,
                        'bundel_id' => $item['bundelId'] ?? null,
                        'qty' => $item['quantity'],
                    ]);
                }
            }
    
            // If there are validation errors, return them
            if (!empty($validationErrors)) {
                return $this->result = [
                    'validator' => $validationErrors,
                    'success' => null,
                    'errors' => null,
                    'object' => null,
                ];
            }
    
            // Set address
            $update_address_with_default_action->execute($cart);
    
            DB::commit();
    
            $results['cart'] = new CartResource($cart, $user);
            return $this->result = [
                'validator' => null,
                'success' => __('home.cartItemAdded'),
                'errors' => null,
                'object' => $results,
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = [
                'validator' => null,
                'success' => null,
                'errors' => $exception->getMessage(),
                'object' => null,
            ];
        }
    }

    /**
     * Store Cart item instance in DB, if this is a first item we create instance of cart in DB.
     *
     * @return colloection of data
     */
    public function update($user)
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            $cart_item = CartItem::with('shopProduct')->where('id', $this->request->cartItemId)->whereIn('cart_id', Cart::where('user_id', $user->id)->pluck('id'))->first();
            if (!$cart_item) {
                return $this->result = ['validator' => [__('home.itemNotFound')], 'success' => null, 'errors' => null, 'object' => null];
            }

            //if increment 0 or 1, user update quantity of item  in cart
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
                $results['cartItem'] = new CartItemResource($cart_item, $user);
                $cart = json_decode(json_encode(new CartResource($user->cart, $user)));
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
    public function delete($user, $id)
    {
        DB::beginTransaction();
        try {
            $cart_item = CartItem::with(['shopProduct', 'cart'])->where('id', $id)->whereIn('cart_id', Cart::where('user_id', $user->id)->pluck('id'))->first();
            if ($cart_item) {
                if ($cart_item->cart->items->count() == 1) {
                    $cart_item->cart->delete();
                } else {
                    $cart_item->delete();
                }

                DB::commit();
                $results['itemsCount'] = $user->cart ? count($user->cart->items) : 0;
                $cart = $user->cart ? json_decode(json_encode(new CartResource($user->cart, $user))) : null;
                $results['totalAmount'] = $cart ? round($cart->itemsTotal, 2) : 0;
                return $this->result = ['validator' => null, 'success' => __('home.cartItemDeleted'), 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => [__('home.itemNotFound')], 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    
    public function deleteBundel($user, $id)
    {
        DB::beginTransaction();
        try {
            $cart_items = CartItem::with(['shopProduct', 'cart'])->where('bundel_id', $id)->whereIn('cart_id', Cart::where('user_id', $user->id)->pluck('id'))->get();

            if (!empty($cart_items)) {
                foreach($cart_items as $item)
                {
                $item->delete();
                }
                DB::commit();
                $results['itemsCount'] = $user->cart ? count($user->cart->items) : 0;
                $cart = $user->cart ? json_decode(json_encode(new CartResource($user->cart, $user))) : null;
                $results['totalAmount'] = $cart ? round($cart->itemsTotal, 2) : 0;
                return $this->result = ['validator' => null, 'success' => __('home.cartItemDeleted'), 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => [__('home.itemNotFound')], 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    

    /**
     * Apply promo code on cart
     */
    public function applyPromoCode($user, $code, ApplyPromoCodeAction $apply_promo_code_action,
        UpdateCartWithPromoCodeId $update_cart_with_promo_codeId) {
        DB::beginTransaction();
        try {
            // find cart
            $cart = Cart::with('items')->where('user_id', $user->id)->first();
            if (is_null($cart)) {
                return $this->result = ['validator' => [__('home.userHasNoCart')], 'success' => null, 'errors' => null, 'object' => null];
            }

            if (is_null($cart->userAddress)) {
                return $this->result = ['validator' => [__('home.select_address_first')], 'success' => null, 'errors' => null, 'object' => null];
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
    function empty($user) {
        DB::beginTransaction();
        try {
            $cart = Cart::with('items')->where('user_id', $user->id)->first();
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
