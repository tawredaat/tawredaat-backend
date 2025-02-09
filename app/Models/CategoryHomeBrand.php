<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryHomeBrand extends Model
{

    protected $table = 'category_home_brands';
    public $timestamps = true;
    protected $fillable = array('category_id', 'brand_id', 'order');
}
