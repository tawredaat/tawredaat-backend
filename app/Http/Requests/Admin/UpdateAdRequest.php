<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdRequest extends FormRequest
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
            'alt_en'=>'required|string|min:2|max:191',
            'alt_ar'=>'required|string|min:2|max:191',
            'url'=>'required|url|max:191',
            'image'=>'nullable|image|mimes:jpeg,png,webp',
            'mobileimg'=>'required|image|mimes:jpeg,png,webp|max:50000',
            'type'=>'required|in:company,category,brand,product',
        ];
    }
}
