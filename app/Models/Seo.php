<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\DB;
use App\Models\ShopProductTranslation;
use Illuminate\Support\Str;

class Seo extends Model
{
    use Translatable;
    public $translatedAttributes = ['title','description','image'];
}