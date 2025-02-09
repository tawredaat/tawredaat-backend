<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class CategoryBanner extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes = ['alt','image','mobile_image' , 'url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
