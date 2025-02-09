<?php

namespace App\Models;

use App\User;

// use Illuminate\Database\Eloquent\Model;

class UserShopProductsView extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shopProduct()
    {
        return $this->belongsTo(ShopProduct::class);
    }
}
