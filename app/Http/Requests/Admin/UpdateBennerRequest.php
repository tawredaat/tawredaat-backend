<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class UpdateBennerRequest extends FormRequest
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
           'altEN' => 'required',
           'altAR' => 'required',
           'urlEN'   => 'required',
           'urlAR'   => 'required',
           'img'   => 'nullable|mimes:png,jpg,jpeg,webp|max:10000000',
            'mobileimg'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',
        ];
    }
}
