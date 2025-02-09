<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\DB;
use App\Models\ShopProductTranslation;
use Illuminate\Support\Str;

class Bundel extends Model
{
    use Translatable;
    public $translatedAttributes = ['name','title','description','seller', 'sla', 'note',  'image' , 'mobile_image' , 'description_meta' , 'keywords' , 'keywords_meta' , 'alt' , 'created_at' , 'updated_at'];

    public $appends = ['price'];


    public function shopProducts()
    {
        return $this->hasMany('App\Models\BundelShopProducts', 'bundel_id');
    }
    
    // Define the relationship with categories
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'bundel_category');
    }
    
    public function products()
    {
        return ShopProduct::join('bundel_shop_product', 'shop_products.id', '=', 'bundel_shop_product.shop_product_id')
            ->where('bundel_shop_product.bundel_id', $this->id)
            ->select(
                'shop_products.*',
                'bundel_shop_product.qty as quantity',
                'bundel_shop_product.locked'
            )
            ->get();
    }

    public function slug()
    {
        $slug_en = BundelTranslation::where('locale' , 'en')->where('bundel_id' , $this->id)->get('name')->toArray();
        return Str::slug($slug_en[0]['name']);
    }
    
    public function items()
    {
        return $this->hasMany('App\Models\CartItem', 'bundel_id');
    }
    
    public function order_items($order_id)
    {
        return OrderItem::where('order_id' , $order_id)->where('bundel_id' , $this->id)->get();
    }
    
    public function bundelItemsTotal()
    {
        // Use sum() to calculate the total price directly in the query
        $total = CartItem::where('bundel_id', $this->id)
            ->join('shop_products', 'cart_items.shop_product_id', '=', 'shop_products.id')
            ->sum('shop_products.new_price');
    
        // Apply the discount percentage
        return $total * ((100 - $this->discount_percentage) / 100);
    }
}