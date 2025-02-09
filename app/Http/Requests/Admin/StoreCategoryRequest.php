<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;

class StoreCategoryRequest extends FormRequest
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
            'name_en'        =>'required|string|min:2|max:191',
            'name_ar'        =>'required|string|min:2|max:191',
            'title_ar'       =>'required|string|min:2|max:191',
            'title_en'       =>'required|string|min:2|max:191',
            'parent'         =>['nullable',Rule::in(Category::where('level','level1')->orWhere('level','level2')->pluck('id'))],
            'keyword'        =>'nullable|string|min:2|max:191',
            'keyword_meta'   =>'nullable|string|min:2|max:191',
            'descri_en'      =>'nullable|string|min:2|max:191',
            'descri_ar'      =>'nullable|string|min:2|max:191',
            'descri_meta_en' =>'nullable|string|min:2',
            'descri_meta_ar' =>'nullable|string|min:2',
            'image'          =>'required|image|mimes:png,jpg,jpeg,webp|max:50000',
            'alt_en'         =>'nullable|string|min:2|max:191',
            'alt_ar'         =>'nullable|string|min:2|max:191',
        ];
    }
}
