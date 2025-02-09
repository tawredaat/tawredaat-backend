<?php

namespace App\Models;


use App\User;

class RfqCategory extends Model
{


    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function rfq(){
        return $this->hasOne(Rfq::class,'id','rfq_id');
    }
}
