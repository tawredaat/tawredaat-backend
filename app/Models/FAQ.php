<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

// use Illuminate\Database\Eloquent\Model;

class FAQ extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = "faqs";

    public $translatedAttributes = ['content'];
}
