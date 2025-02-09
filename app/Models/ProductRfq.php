<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ProductRfq extends Model
{
    protected $fillable = ['message', 'user_id', 'company_id', 'company_product_id','notes','qty'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companyProduct()
    {
        return $this->belongsTo(CompanyProduct::class);
    }

    public function company()
    {
       return $this->belongsTo(Company::class);
    }
}
