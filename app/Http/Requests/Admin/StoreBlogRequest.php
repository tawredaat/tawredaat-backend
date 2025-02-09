<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'title_en'=>'required|string|min:2|max:191',
            'title_ar'=>'required|string|min:2|max:191',
            'image'=>'required|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'alt_ar'=>'required|string|min:2|max:191',
            'alt_en'=>'required|string|min:2|max:191',
            'descri_ar'=>'nullable|string|min:2',
            'descri_en'=>'nullable|string|min:2',
            'descri_meta_ar'=>'nullable|string|min:2',
            'descri_meta_en'=>'nullable|string|min:2',
            'tags_ar'=>'nullable|string|min:2',
            'tags_en'=>'nullable|string|min:2',
            'tags_meta_en'=>'nullable|string|min:2',
            'tags_meta_ar'=>'nullable|string|min:2',
            'slug_en'=>'nullable|string|min:2',
            'slug_ar'=>'nullable|string|min:2',
            'page_title_en'=>'nullable|string|min:2',
            'page_title_ar'=>'nullable|string|min:2',
            'meta_title_en'=>'nullable|string|min:2',
            'meta_title_ar'=>'nullable|string|min:2',
        ];
    }
}
