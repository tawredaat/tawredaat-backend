<?php

namespace App\Models;


class RfqResponse extends Model
{

    public function company(){
        return $this->hasOne(Company::class,'id','company_id');
    }

    public function rfq(){
        return $this->belongsTo(Rfq::class,'rfq_id');
    }
}
