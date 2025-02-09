<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class UpdateShopBennerRequest extends FormRequest
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
            'img'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',
            'mobileimg'   => 'nullable|mimes:png,jpg,jpeg,webp|max:50000',
            'altEN' => 'nullable|string|min:2|max:191',
            'altAR' => 'nullable|string|min:2|max:191',
             'url'   => 'nullable|url|max:191',
        ];
    }
}
