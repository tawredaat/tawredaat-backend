<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Exception;

class Promocode extends Model implements TranslatableContract
{

    use Translatable;
    public $translatedAttributes = ['name'];

    public function getDiscountValue($subtotal, $delivery_charge)
    {

        if ($this->discount_type == 'value') {
            $discount = $this->discount;
            $total = $subtotal - $discount + $delivery_charge;

            return [
                'subtotal' => $subtotal,
                'total' => round($total, 3),
                'discount' => $discount,
                'delivery_charge' => $delivery_charge,
            ];
        } elseif ($this->discount_type == 'percentage') {
            $discount = $subtotal * ($this->discount / 100);
            $total = $subtotal - $discount + $delivery_charge;

            return [
                'subtotal' => $subtotal,
                'total' => round($total, 3),
                'discount' => $discount,
                'delivery_charge' => $delivery_charge,
            ];
        } elseif ($this->discount_type == 'remove shipping fees') {
            $discount = 0;
            $total = $subtotal - $discount + $delivery_charge;

            return [
                'subtotal' => $subtotal,
                'total' => round($total, 3),
                'discount' => $discount,
                'delivery_charge' => 0,
            ];
        } else {
            throw new Exception('Promo code discount type is unidentified');
        }

    }
  
  	public function is_valid()
    {
      $now = Carbon::now();
      if($this->uses > 0 && ($this->valid_from <= $now && $this->valid_to >= $now))
      {
        return true;
      }else{
        return false;
      }
    }

}
