<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBennerRequest extends FormRequest
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
           'altEN' => 'required|string|min:2|max:191',
           'altAR' => 'required|string|min:2|max:191',
           'urlEn'   => 'required|max:191',
           'urlAr'   => 'required|max:191',
           'imgAr'   => 'required|mimes:png,jpg,jpeg,webp|max:50000',
           'mobileimgAr'   => 'required|mimes:png,jpg,jpeg,webp|max:50000',
           'imgEn'   => 'required|mimes:png,jpg,jpeg,webp|max:50000',
           'mobileimgEn'   => 'required|mimes:png,jpg,jpeg,webp|max:50000',
        ];

    }
}
