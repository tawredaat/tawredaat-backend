<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class BrandVisitor extends Model
{
    public function user()
    {
       return $this->belongsTo('App\User', 'user_id');
    }
}
