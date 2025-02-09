<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
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
            'name_ar'=>'required|string|min:2|max:191',
            'name_en'=>'required|string|min:2|max:191',
            'flag'=>'nullable|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'alt_ar'=>'required|string|min:2|max:191',
            'alt_en'=>'required|string|min:2|max:191',
        ];
    }
}
