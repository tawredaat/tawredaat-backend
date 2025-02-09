<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'name_ar'       => 'required|string|min:2|max:191',
            'name_en'       => 'required|string|min:2|max:191',
            'note_ar'       => 'sometimes',
            'note_en'       => 'sometimes',
            'additional_percentage' => 'required|numeric|between:0,100',
            'payment_type' => 'required|in:0,1',
            'image'=>'sometimes|image|mimes:jpg,jpeg,png,gif,bmp,webp',
        ];
    }
}
