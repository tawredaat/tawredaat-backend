<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdsBannerRequest extends FormRequest
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
           'firstImage_en'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',
           'firstImage_ar'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',

            'mobileFirstImage_en'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',
            'mobileFirstImage_ar'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',

           'secondImage_en'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',
           'secondImage_ar'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',

            'mobileSecondImage_en'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',
            'mobileSecondImage_ar'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',


            'firstImageAlt_en' => 'nullable|string|min:2|max:191',
           'firstImageAlt_ar' => 'nullable|string|min:2|max:191',
            'secondImageAlt_en' => 'nullable|string|min:2|max:191',
           'secondImageAlt_ar' => 'nullable|string|min:2|max:191',
           'firstURL' => 'nullable|url|max:191',
           'secondURL' => 'nullable|url|max:191',
        ];

    }
}
