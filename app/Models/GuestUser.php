<?php

namespace App\Models;

class GuestUser extends Model
{
    public function cart()
    {
        return $this->hasOne('App\Models\Cart');
    }
    public function items()
    {
        return $this->hasManyThrough('App\Models\CartItem', 'App\Models\Cart');
    }
}
