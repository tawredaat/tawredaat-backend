<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
//use Illuminate\Database\Eloquent\Model;

class Certificate extends Model implements TranslatableContract
{
	use Translatable;
	public $translatedAttributes = ['CertiName'];
    //protected $fillable =['name','company_id'];
}
