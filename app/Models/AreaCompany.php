<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class AreaCompany extends Model
{

	protected $table = 'area_company';
    public function area()
    {
        return $this->belongsTo('App\Models\Arae');
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
