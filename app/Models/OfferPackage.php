<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class OfferPackage extends Model
{

    public function shopProduct()
    {
       return $this->belongsTo('App\Models\ShopProduct', 'shop_product_id');
    }
    public function quantityType()
    {
       return $this->belongsTo('App\Models\QuantityType', 'quantity_type_id');
    }
    public function gifts()
    {
       return $this->hasMany('App\Models\OfferPackageGift', 'offer_package_id');
    }
}
