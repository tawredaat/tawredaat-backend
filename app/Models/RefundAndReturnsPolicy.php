<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

// use Illuminate\Database\Eloquent\Model;

class RefundAndReturnsPolicy extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes = ['content'];
}
