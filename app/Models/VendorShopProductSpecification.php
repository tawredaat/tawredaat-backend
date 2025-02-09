<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

class VendorShopProductSpecification extends Model
{
    use Translatable;
    public $translatedAttributes = ['value'];

    public function product()
    {
        return $this->belongsTo(VendorShopProduct::class);
    }

    public function products($specification_id)
    {
        return VendorShopProductSpecification::where('specification_id', $specification_id)
            ->get();
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
