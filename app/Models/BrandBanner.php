<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class BrandBanner extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes = ['alt'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
