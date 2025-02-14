<?php

namespace App\Http\Requests\Admin\VendorShopProduct;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MultiApproveRequest extends FormRequest
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
        ];
    }
}