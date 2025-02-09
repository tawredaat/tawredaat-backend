<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class BrandCategory extends Model
{

	
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand','brand_id');
    }
    public function brands()
    {
        return $this->belongsToMany('App\Models\Brand');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
