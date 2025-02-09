<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

class BundelCategory extends Model
{
    use Translatable;
    
    protected $table = 'bundel_category'; // Replace with your actual table name
    public $translatedAttributes = ['value'];

    public function product()
    {
        return $this->belongsTo(ShopProduct::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function products($specification_id)
    {
        return ProductSpecification::where('specification_id', $specification_id)->get();
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    } 
}
