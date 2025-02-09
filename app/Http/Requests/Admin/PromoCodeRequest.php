<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PromoCodeRequest extends FormRequest
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
            'name_ar' => 'required|string|min:2|max:191',
            'name_en' => 'required|string|min:2|max:191',
            'code' => 'required|string|unique:promocodes|min:2|max:191',
            'discount_type' => 'required|in:value,percentage,remove shipping fees',
            'discount' => 'required|numeric|min:0|max:99999.99',
            'max_amount' => 'sometimes|min:0|max:1000000',
            'min_amount' => 'required|min:0|max:100000',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date', 
            'uses' => 'required|integer',
          	'brand_id' => 'required|array', // Ensure it's an array
    		'brand_id.*' => 'exists:brands,id', // Ensure each selected ID exists in the brands table
        ];
    }
}
