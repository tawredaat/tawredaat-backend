<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;

class StoreBundelRequest extends FormRequest
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
            'image_ar'=>'required|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'image_en'=>'required|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'mobileimg_ar'=>'required|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'mobileimg_en'=>'required|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'alt_en'=>'nullable|string|min:2|max:191',
            'alt_ar'=>'nullable|string|min:2|max:191',
            'title_en'=>'nullable|string|min:2|max:191',
            'title_ar'=>'nullable|string|min:2|max:191',
            'keywords_ar'=>'nullable|string|min:2',
            'keywords_en'=>'nullable|string|min:2',
            'keywords_meta_en'=>'nullable|string|min:2',
            'keywords_meta_ar'=>'nullable|string|min:2',
            'description_ar'=>'nullable|string|min:2',
            'description_en'=>'nullable|string|min:2',
            'description_meta_ar'=>'nullable|string|min:2',
            'description_meta_en'=>'nullable|string|min:2',
            'sku_code'=>'nullable|string|min:2|max:191',
            'old_price'=>'nullable|string|min:1',
            'new_price'=>'required|string|min:1',
            'qty'=> 'required|regex:/^\d+(\.\d{1,2})?$/',
            'seller_ar' => 'required|string|max191',
            'seller_en' => 'required|string|max191',
            'sla_ar' => 'required|string|max191',
            'sla_en' => 'required|string|max191',
            'note_ar' => 'required|string|max191',
            'note_en' => 'required|string|max191',
        ];
    }
}
