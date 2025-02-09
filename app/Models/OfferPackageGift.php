<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class OfferPackageGift extends Model
{
    public function shopProduct()
    {
       return $this->belongsTo('App\ShopProduct', 'shop_product_id');
    }
    public function offerPackage()
    {
       return $this->belongsTo('App\OfferPackage', 'offer_package_id');
    }
}
