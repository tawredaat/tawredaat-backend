<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }
}
