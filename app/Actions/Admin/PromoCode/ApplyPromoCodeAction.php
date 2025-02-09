<?php

namespace App\Actions\Admin\PromoCode;

use App\Models\Promocode;
use Exception;

class ApplyPromoCodeAction
{
    public function execute($promo_code_id, $total)
    {
        if (is_null($promo_code_id)) {
            return;
        }

        $promo_code = Promocode::findOrFail($promo_code_id);

        if ($promo_code->discount_type == 'value') {
            return [
                'discount' => $promo_code->discount,
                'delivery_charge' => null,
            ];
        } elseif ($promo_code->discount_type == 'percentage') {
            return [
                'discount' => $total * ($promo_code->discount / 100),
                'delivery_charge' => null,
            ];
        } elseif ($promo_code->discount_type == 'remove shipping fees') {
            return [
                'discount' => 0,
                'delivery_charge' => 0,
            ];
        } else {
            throw new Exception('Promo code discount type is unidentified');
        }
    }
}
