<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Specification extends Model implements TranslatableContract
{
   	use Translatable;
	public $translatedAttributes = ['name'];

    public function values()
    {
        return $this->hasMany('App\Models\ProductSpecification','specification_id')->groupBy('value');
    }
    public function shop_values()
    {
        return $this->hasMany('App\Models\ShopProductSpecification','specification_id');
    }
}
