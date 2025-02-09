<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\DB;
use App\Models\ShopProductTranslation;

class ShopProduct extends Model
{
    use Translatable;
    public $translatedAttributes = ['name', 'slug', 'alt', 'title', 'keywords', 'keywords_meta', 'description', 'description_meta' , 'note' , 'seller' , 'sla'];

    public $appends = ['price'];

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function scopeForHome($query)
    {
        return $query->select('id', 'image', 'sku_code', 'old_price', 'new_price', 'qty',
            'brand_id', 'category_id', 'featured'
        )
            ->with(['translations' => function ($query) {
                $query->select('id', 'shop_product_id', 'slug', 'name', 'alt', 'locale',
                    'description');
            }])
            ->with(['brand' => function ($query) {
                $query->select('id', 'image', 'mobileimg')
                    ->with(['translations' => function ($query) {
                        $query->select('id', 'brand_id', 'name', 'alt', 'locale',
                            'description');
                    }]);
            }]);
    }

    public function getPriceAttribute()
    {
        return $this->new_price;
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function specifications()
    {
        return $this->hasMany('App\Models\ShopProductSpecification', 'shop_product_id');
    }
    public function companyProducts()
    {
        return $this->hasMany('App\Models\CompanyProduct', 'product_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }
    public function QuantityType()
    {
        return $this->belongsTo('App\Models\QuantityType', 'quantity_type_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    //return images belongs to product
    public function images()
    {
        return $this->morphMany('App\Models\File', 'model');
    }

    public function getBestRankCompany()
    {
        $companyIds = $this->companyProducts->pluck('company_id');
        $bestRankCompanyNumber = Company::whereIn('id', $companyIds)->orderBy('rank', 'desc')->first();

        if (!is_null($bestRankCompanyNumber)) {
            return $bestRankCompanyNumber['company_phone'];
        } else {
            return null;
        }

    }

    public function allImages()
    {
        // define empty array to store images inside it   
        $all_imgs = [];
        //check if image one has value or null 
        //dd(DB::table('shop_products')->select('image')->where('id' , $this->id)->get()->first()->image);
        if(DB::table('shop_products')->select('image')->where('id' , $this->id)->get()->first()->image !== null)
        {   
            //if image one have value push value into all_imgs array else array still empty
            array_push( $all_imgs, asset('storage/'.DB::table('shop_products')->select('image')->where('id' , $this->id)->get()->first()->image));
        }
        
        if(DB::table('shop_products')->select('image_name1')->where('id' , $this->id)->get()->first()->image_name1 !== null)
        {   
            //if image one have value push value into all_imgs array else array still empty
            array_push( $all_imgs, asset('storage/'.DB::table('shop_products')->select('image_name1')->where('id' , $this->id)->get()->first()->image_name1));
        }

        if(DB::table('shop_products')->select('image_name2')->where('id' , $this->id)->get()->first()->image_name2 !== null)
        {
            array_push( $all_imgs, asset('storage/'.DB::table('shop_products')->select('image_name2')->where('id' , $this->id)->get()->first()->image_name2));
        }

        if(DB::table('shop_products')->select('image_name3')->where('id' , $this->id)->get()->first()->image_name3 !== null)
        {
            array_push( $all_imgs, asset('storage/'.DB::table('shop_products')->select('image_name3')->where('id' , $this->id)->get()->first()->image_name3));
        } 
       // return all_imgs array in resource
        return $all_imgs;
    }

    public function slug()
    {
        $slug_en = ShopProductTranslation::where('locale' , 'en')->where('shop_product_id' , $this->id)->get('slug')->toArray();
        return $slug_en[0]['slug'];
    }
}