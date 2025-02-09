<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class City extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
}
