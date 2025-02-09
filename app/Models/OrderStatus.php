<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class OrderStatus extends Model implements TranslatableContract
{
	protected $table = 'order_statuses';
	use Translatable;
	public $translatedAttributes = ['name'];
}
