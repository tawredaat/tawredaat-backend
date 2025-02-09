<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class CompanyVisitor extends Model
{
    public function user()
    {
       return $this->belongsTo('App\User', 'user_id');
    }
}
