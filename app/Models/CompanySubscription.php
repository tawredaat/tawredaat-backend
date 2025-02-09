<?php

namespace App\Models;

class CompanySubscription extends Model
{
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
