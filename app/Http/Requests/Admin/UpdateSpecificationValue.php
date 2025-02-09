<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


class UpdateSpecificationValue extends FormRequest
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
            'value_en'=>'required|string|min:2|max:191',
            'value_ar'=>'required|string|min:2|max:191',
            'shopProductSpecification_id' => 'required|exists:shop_product_specifications,id',
            
        ];
    }
}
