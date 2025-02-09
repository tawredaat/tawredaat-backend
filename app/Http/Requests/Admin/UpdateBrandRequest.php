<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Country;

class UpdateBrandRequest extends FormRequest
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
            'name_en'=>'required|string|min:2|max:191',
            'name_ar'=>'required|string|min:2|max:191',
            'image'=>'nullable|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'mobileimg'=>'nullable|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'pdf'=>'nullable|file|mimes:pdf',
            'alt_en'=>'nullable|string|min:2|max:191',
            'alt_ar'=>'nullable|string|min:2|max:191',
            'title_en'=>'nullable|string|min:2|max:191',
            'title_ar'=>'nullable|string|min:2|max:191',
            'origin'=>'nullable|string|min:2|max:191',
            'keywords_ar'=>'nullable|string|min:2',
            'keywords_en'=>'nullable|string|min:2',
            'keywords_meta'=>'nullable|string|min:2',
            'description_ar'=>'nullable|string|min:2',
            'description_en'=>'nullable|string|min:2',
            'description_meta_ar'=>'nullable|string|min:2',
            'description_meta_en'=>'nullable|string|min:2',
             'country_id'         =>['nullable',Rule::in(Country::pluck('id'))],
            'categories'=>'required|array',
            'categories.*'=>['distinct',Rule::in(Category::where('level','level3')->pluck('id'))],
            'products_title_en'=>'nullable|string|min:2|max:191',
            'products_title_ar'=>'nullable|string|min:2|max:191',
            'products_description_en'=>'nullable|string|min:2|max:65533',
            'products_description_ar'=>'nullable|string|min:2|max:65533',
            'products_keywords_en'=>'nullable|string|min:2|max:65533',
            'products_keywords_ar'=>'nullable|string|min:2|max:65533',
            'distributors_title_en'=>'nullable|string|min:2|max:191',
            'distributors_title_ar'=>'nullable|string|min:2|max:191',
            'distributors_description_en'=>'nullable|string|min:2|max:65533',
            'distributors_description_ar'=>'nullable|string|min:2|max:65533',
            'distributors_keywords_ar'=>'nullable|string|min:2|max:65533',
            'distributors_keywords_en'=>'nullable|string|min:2|max:65533',
        ];
    }
}
