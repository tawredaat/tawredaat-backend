<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryHomeCategory extends Model
{

    protected $table = 'category_home_categories';
    public $timestamps = true;
    protected $fillable = array('parent_category_id', 'child_category_id', 'order');
    
    public function parent_category()
    {
        return $this->belongsTo('App\Models\Category', 'parent');
    }
}
