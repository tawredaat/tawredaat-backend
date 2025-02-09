<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

class ShopProductSpecification extends Model
{
    use Translatable;
    public $translatedAttributes = ['value'];

    public function product()
    {
        return $this->belongsTo(ShopProduct::class);
    }
    public function products($specification_id)
    {
        return ProductSpecification::where('specification_id', $specification_id)->get();
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    } 
}
