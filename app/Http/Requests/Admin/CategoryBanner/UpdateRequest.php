<?php

namespace App\Http\Requests\Admin\CategoryBanner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'alt_en' => 'required|string|min:2|max:191',
            'alt_ar' => 'required|string|min:2|max:191',
            'url' => 'required|max:191',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',
            'mobile_image' => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',
        ];
    }
}
