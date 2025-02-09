<?php

namespace App\Http\Requests\Admin\VendorShopProduct;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApproveRequest extends FormRequest
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
            'vendor_id' => 'required|exists:vendors,id',
            'id' => ['required', Rule::exists('vendor_shop_products', 'id')
                    ->where('vendor_id', $this->vendor_id)],
        ];
    }
}