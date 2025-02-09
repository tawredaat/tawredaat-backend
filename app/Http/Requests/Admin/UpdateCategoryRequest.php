<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name_en'        =>'required|min:2|max:191',
            'name_ar'        =>'required|min:2|max:191',
            'title_ar'       =>'required|min:2|max:191',
            'title_en'       =>'required|min:2|max:191',
            'parent'         =>'nullable',
            'keyword'        =>'nullable|min:2',
            'keyword_meta'   =>'nullable|min:2',
            'descri_en'      =>'nullable|min:2',
            'descri_ar'      =>'nullable|min:2',
            'descri_meta_en' =>'nullable|min:2',
            'descri_meta_ar' =>'nullable|min:2',
            'image'          =>'nullable|mimes:png,jpg,jpeg,webp|max:10000000',
            'alt_en'         =>'nullable|min:2|max:191',
            'alt_ar'         =>'nullable|min:2|max:191',
        ];
    }
}
