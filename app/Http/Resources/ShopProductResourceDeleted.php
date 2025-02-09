<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cookie;
use App\Models\Setting;

class ShopProductResourceDeleted extends JsonResource
{
    /**
     * ShopProductResourceDeleted constructor.
     * @param $resource
     */
    public function __construct($resource = [])
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $setting = Setting::first();
        $img = $setting->site_logo;
        return [
            'id' => 0,
            'name' => __('home.DeletedShopProduct'),
            'image' => $img ? str_replace('\\','/',asset('storage/'.$img)) : null,
            'pdf' => "",
            'sku_code'=>"",
            'alt'=>"",
            'description'=>"",
            'old_price'=>0,
            'new_price'=>0,
            'quantity_type'=>__('home.DeletedShopProduct'),
            'qty'=>0,
            'brand'=>["name"=>__('home.DeletedShopProduct')],
            'specifications'=> [],
            'inCart'=>0,
            'cart_item_id'=>0,
            'cart_item_qty'=> 0,
            'images'=>[],
        ];
    }
}
