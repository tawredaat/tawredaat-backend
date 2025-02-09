<?php

namespace App\Http\Requests\Admin\BrandBanner;

use Illuminate\Foundation\Http\FormRequest;

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
            'brand_id' => 'required|exists:brands,id',
            'alt_en' => 'required|string|min:2|max:191',
            'alt_ar' => 'required|string|min:2|max:191',
            'url' => 'required|max:191',
            'image' => 'required|mimes:png,jpg,jpeg,webp|max:50000',
            'mobile_image' => 'required|mimes:png,jpg,jpeg,webp|max:50000',
        ];

    }
}
