<?php

namespace App\Models;


use App\User;

class Rfq extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function statusColor()
    {
        if($this->status=='Responsed')
            return '#008000';
        elseif($this->status=='Not Responsed')
            return '#000';
        else
            return '#FF0000';
    }

    public function attachments()
    {
        return $this->hasMany(UserRfqAttachment::class);
    }

}
