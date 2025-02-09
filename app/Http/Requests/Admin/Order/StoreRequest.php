<?php

namespace App\Http\Requests\Admin\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'address_id' => ['required', Rule::exists('user_addresses', 'id')
                    ->where('user_id', $this->user_id)],
            'payment_id' => 'required|exists:payments,id',
            'delivery_charge' => 'nullable|numeric',
            'promo_code_id' => 'nullable|exists:promocodes,id',
            'order_from' => 'required|in:Web,Mobile',
            'comment' => 'nullable|string',
            'product_id.*' => 'nullable|exists:shop_products,id',
            'quantity.*' => 'required|numeric',
            'manual_product_name.*' => 'nullable|required_without:product_id',
            'price.*' => 'nullable|numeric',
        ];
    }
}
