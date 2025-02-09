<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AreaOperation extends Pivot
{
	protected $table = 'area_operations';
    //protected $fillable = ['company_id','name_en','name_ar'];
    public function area(){
    	return $this->belongsTo('App\Models\Area');
    }
}
