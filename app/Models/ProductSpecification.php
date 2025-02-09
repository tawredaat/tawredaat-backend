<?php

namespace App\Models;

class ProductSpecification extends Model 
{

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function products($specification_id)
    {
        return ProductSpecification::where('specification_id',$specification_id)->get();
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
