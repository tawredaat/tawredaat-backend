<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OfferPackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shop_product_id' => 'required|exists:shop_products,id',
            'shop_product_qty'=> 'required|regex:/^\d+(\.\d{1,2})?$/',
            'shop_product_qty_type'=>'required|exists:quantity_types,id',
            'price'           => 'required|string|min:2|max:191',
            'gift_products' => 'required|array',
            'gift_products.*' => 'required|exists:shop_products,id|distinct',
            'gift_qtys' => 'required|array',
            'gift_qtys.*' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'gift_qty_types' => 'required|array',
            'gift_qty_types.*' => 'required|exists:quantity_types,id',
        ];
    }
}
