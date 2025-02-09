<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\DB;
use App\Models\ShopProductTranslation;
use Illuminate\Support\Str;

class DynamicPageShopProducts extends Model
{
     protected $table = 'dynamic_pages_shop_products'; // Replace with your actual table name
}