<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\DB;
use App\Models\ShopProductTranslation;
use Illuminate\Support\Str;

class DynamicPage extends Model
{
    use Translatable;
    public $translatedAttributes = ['name','description','page_title','alt' , 'main_banner' , 'main_banner_mobile'];


    public function shopProducts()
    {
        return $this->belongsToMany('App\Models\ShopProduct', 'dynamic_pages_shop_products', 'dynamic_page_id', 'shop_product_id');
    }
    

    public function slug()
    {
        $slug_en = DynamicPageTranslation::where('locale' , 'en')->where('dynamic_page_id' , $this->id)->get('name')->toArray();
        return Str::slug($slug_en[0]['name']);
    }
}