<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class FAQTranslation extends Model
{
    protected $table = "faq_translations";

    protected $fillable = ['faq_id', 'content'];

    public $timestamps = false;

    public function faq()
    {
        return $this->belongsTo(FAQ::class, 'faq_id');
    }
}
