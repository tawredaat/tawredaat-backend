<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'email' => 'required|email|min:2|max:191',
            'favicon' => 'nullable|image|max:50000',
            'logo_en' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
            'logo_ar' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
            'rfq_banner_en' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
            'rfq_banner_ar' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
            'brand_store_banner' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
            'site_logo_en' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
            'site_logo_ar' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
            'footer_logo_en' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
            'footer_logo_ar' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
            'alt_en' => 'nullable|string|min:2|max:191',
            'alt_ar' => 'nullable|string|min:2|max:191',
            'phone' => 'required|string|min:2|max:191',
            'fax' => 'nullable|string|min:2|max:191',
            'facebook' => 'nullable|string|min:2|max:191',
            'insta' => 'nullable|string|min:2|max:191',
            'youtupe' => 'nullable|string|min:2|max:191',
            'linkedin' => 'nullable|string|min:2|max:191',
            'twitter' => 'nullable|string|min:2|max:191',
            'address_en' => 'required|string|min:2|max:191',
            'address_ar' => 'required|string|min:2|max:191',
            'description_en' => 'required|string|min:2|max:6000',
            'description_ar' => 'required|string|min:2|max:6000',
            'title_en' => 'required|string|min:2|max:191',
            'title_ar' => 'required|string|min:2|max:191',
            //'footerLogoAlt_en' => 'required|string|min:2|max:191',
            //'footerLogoAlt_ar' => 'required|string|min:2|max:191',
            'siteLogoAlt_en' => 'required|string|min:2|max:191',
            'siteLogoAlt_ar' => 'required|string|min:2|max:191',
            'keywords_en' => 'required|string|min:2|max:6000',
            'keywords_ar' => 'required|string|min:2|max:6000',
            'Meta_Description_en' => 'required|string|min:2|max:6000',
            'Meta_Description_ar' => 'required|string|min:2|max:6000',
            'free_shipping_amount' => 'required|numeric',
          	'minimum_order_amount' => 'required|numeric',
        ];
    }
}
