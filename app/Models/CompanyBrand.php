<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class CompanyBrand extends Model
{
    public function type()
    {
        return $this->belongsTo('App\Models\CompanyType','company_type_id');
    }
     public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id');
    }
}
