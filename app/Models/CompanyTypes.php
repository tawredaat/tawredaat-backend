<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class CompanyTypes extends Model
{

	protected $table = 'company_company_type';
    public function type()
    {
        return $this->belongsTo('App\Models\CompanyType','company_type_id');
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
