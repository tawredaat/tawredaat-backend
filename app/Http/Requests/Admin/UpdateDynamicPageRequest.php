<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;

class UpdateDynamicPageRequest extends FormRequest
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
            'url' => [
                'url',
                'min:2',
                'max:191',
                Rule::unique('dynamic_pages', 'url')->ignore($this->route('dynamic_page'))
            ],
            'name_en' => 'required|string|min:2|max:191',
            'name_ar' => 'required|string|min:2|max:191',
            'main_banner_en' => 'sometimes|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'main_banner_ar' => 'sometimes|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'main_banner_mobile_en' => 'sometimes|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'main_banner_mobile_ar' => 'sometimes|image|mimes:jpg,jpeg,png,gif,bmp,webp',
            'alt_en' => 'nullable|string|min:2|max:191',
            'alt_ar' => 'nullable|string|min:2|max:191',
            'page_title_en' => 'nullable|string|min:2|max:191',
            'page_title_ar' => 'nullable|string|min:2|max:191',
            'description_ar' => 'nullable|string|min:2',
            'description_en' => 'nullable|string|min:2',
            'shopProducts' => 'required|array',
            'shopProducts.*' => [
                'required',
                'integer',
                Rule::exists('shop_products', 'id') // Ensure each product ID exists in the shop_products table
            ],
        ];
    }
}
