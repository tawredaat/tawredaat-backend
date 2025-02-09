<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class GeneralRfqProduct extends Model
{
    protected $fillable = ['user_id', 'general_rfq_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generalRfq()
    {
        return $this->belongsTo(GeneralRfq::class);
    }

    public function companyProduct()
    {
        return $this->belongsTo(CompanyProduct::class, 'company_product_id');
    }
}
