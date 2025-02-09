<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Advertising extends Model implements TranslatableContract
{
    use Translatable;
	public $translatedAttributes = ['alt'];
}
