<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cookie;

class ShopProductForHomeResource extends JsonResource
{
    private $user;
    private $cart;
    /**
     * ShopProductResource constructor.
     * @param $resource
     */
    public function __construct($resource, $user = null, $cart = [])
    {
        parent::__construct($resource);
        $this->user = $user;
        $this->cart = $cart;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $in_cart = 0;
        $product_cart_item_id = null;
        $product_cart_item_qty = 0;
        $user = null;

        if (request()->header('deviceId')) {
            $user = User::where('device_id', request()->header('deviceId'))->first();
        } elseif ($this->user) {
            $user = $this->user;
        } elseif (Cookie::get('user_id')) {
            $user = User::where('id', Cookie::get('user_id'))->first();
        }

        if ($user != false && isset($user->items)
            && in_array($this->id, $user->items->pluck('shop_product_id')->toArray())) {
            $in_cart = 1;
            $product_cart_item_id = $user->items->where('shop_product_id', $this->id)
                ->where('cart_id', $user->cart->id)->first()->id;
            $product_cart_item_qty = $user->items->where('shop_product_id', $this->id)
                ->where('cart_id', $user->cart->id)->first()->qty;
        } else {
            //for guest cart item
            $cart = [];
            if (Cookie::get('shopping_cart')) {
                $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                $cart = json_decode($cookie_data, true) ? json_decode($cookie_data, true) : [];
            }
            if (request()->ajax()) {
                $cart = $this->cart;
            }

            $item_id_list = array_column($cart, 'item_id');
            if (is_array($cart) && in_array($this->id, $item_id_list)) {
                $in_cart = 1;
                foreach ($cart as $key => $value) {
                    if ($cart[$key]["item_id"] == $this->id) {
                        $product_cart_item_qty = $cart[$key]["item_quantity"];
                    }

                }
            }
        }

        return [
            'id' => intval($this->id),
            'inCart' => intval($in_cart),
            'name' => $this->name,
            'slug' => $this->slug(),
            'image' => $this->image ? str_replace('\\', '/', asset('storage/' . $this->image)) : null,
            'sku_code' => $this->sku_code,
            'alt' => $this->alt,
            'description' => $this->description,
            'old_price' => "$this->old_price",
            'new_price' => "$this->new_price",
            'qty' => "$this->qty",
            'out_of_stock' => (bool) ($this->qty == 0),
            'brand' => new BrandForHomeResource($this->brand),
            'cart_item_id' => intval($product_cart_item_id),
            'cart_item_qty' => "$product_cart_item_qty",
        ];
    }
}
