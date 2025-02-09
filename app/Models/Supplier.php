<?php

namespace App\Models;


use App\User;

class Supplier extends Model
{

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }

}
