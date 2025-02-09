<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class VendorShopProduct extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'alt', 'title', 'keywords',
        'keywords_meta', 'description', 'description_meta'];

    public $appends = ['price'];

    public function scopeVendorShopProducts($query, $id = null)
    {
        $vendor_id = $id ?? Auth('vendor')->user()->id;
        return $query->where('vendor_id', $vendor_id);
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
        return $this->hasMany('App\Models\VendorShopProductSpecification',
            'vendor_shop_product_id');
    }

    public function companyProducts()
    {
        return $this->hasMany('App\Models\CompanyProduct', 'product_id');
    }

    public function orderItems()
    {
        return $this->belongsToMany('App\Models\OrderItem', 'shop_product_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function quantityType()
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
}