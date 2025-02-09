<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class SiteVisitor extends Model
{
    //
    public function user()
    {
       return $this->belongsTo('App\User', 'user_id');
    }
}
