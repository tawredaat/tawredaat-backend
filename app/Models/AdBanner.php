<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class AdBanner extends Model implements TranslatableContract
{
    use Translatable;
	public $translatedAttributes = ['firstImage','firstImageAlt','secondImage','secondImageAlt'];
}
