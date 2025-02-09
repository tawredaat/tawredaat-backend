<?php

namespace App\Http\Requests\Admin;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;

class StoreBrandRequest extends FormRequest
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
            'image'=>'required|image|mimes:png,jpg,jpeg,webp|max:50000',
            'mobileimg'=>'required|image|mimes:png,jpg,jpeg,webp|max:50000',
            'pdf'=>'nullable|file|mimes:pdf|max:50000',
            'alt_en'=>'nullable|string|min:2|max:191',
            'alt_ar'=>'nullable|string|min:2|max:191',
            'title_en'=>'nullable|string|min:2|max:191',
            'title_ar'=>'nullable|string|min:2|max:191',
            'origin'=>'nullable|string|min:2|max:191',
            'keywords_ar'=>'nullable|string|min:2|max:65533',
            'keywords_en'=>'nullable|string|min:2|max:65533',
            'keywords_meta'=>'nullable|string|min:2|max:65533',
            'description_ar'=>'nullable|string|min:2|max:65533',
            'description_en'=>'nullable|string|min:2|max:65533',
            'description_meta_ar'=>'nullable|string|min:2|max:65533',
            'description_meta_en'=>'nullable|string|min:2|max:65533',
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
