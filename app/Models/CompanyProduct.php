<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class CompanyProduct extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
     public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id');
    }
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand','brand_id');
    }
    public function unit()
    {
        return $this->belongsTo('App\Models\Unit','unit_id');
    }
   public static function types($brand_id,$company_id)
    {
       return  \App\Models\CompanyBrand::where('brand_id',$brand_id)->where('company_id',$company_id)->get();
    }
}
