<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralRfq extends Model
{
    protected $fillable = ['user_id', 'company_id', 'message'];
    protected $appends = ['products'];

    public function user()
    {
       return $this->belongsTo('App\User', 'user_id');
    }

    public function company()
    {
      return   $this->belongsTo('App\Models\Company', 'company_id');
    }

    public function generalRfqProducts()
    {
        return $this->hasMany(GeneralRfqProduct::class);
    }

    public function getProductsAttribute()
    {
        $generalRfqProducts = $this->generalRfqProducts;

        $products = array();

        foreach ($generalRfqProducts as $generalRfqProduct){
            array_push($products, $generalRfqProduct->companyProduct);
        }

        return collect($products);
    }
}