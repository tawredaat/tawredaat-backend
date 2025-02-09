<?php

namespace App\Http\Requests\Company;

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
        $id = $this->route('company');
        return [
            'logo'              => 'nullable|mimes:png,jpg,jpeg,webp|max:10000000',
            'alt_en'            => 'required|min:2|max:191',
            'alt_ar'            => 'required|min:2|max:191',
            'name_en'           => 'required|min:2|max:191',
            'name_ar'           => 'required|min:2|max:191',
            'title_en'          => 'nullable|min:2',
            'title_ar'          => 'nullable|min:2',
            'descri_en'         => 'nullable|min:2',
            'descri_ar'         => 'nullable|min:2',
            'descri_meta_en'    => 'nullable|min:2',
            'descri_meta_ar'    => 'nullable|min:2',
            'keyword_meta'      => 'nullable|min:2',
            'keyword_en'        => 'nullable|min:2',
            'keyword_ar'        => 'nullable|min:2',
            'date'              => 'nullable|min:2',
            'sales_mobile'      => 'nullable|min:2',
            'company_phone'     => 'nullable|min:2',
            'whatsup_number'     => 'nullable|min:2',
            'company_email'     =>'required|email|unique:companies,company_email,'.$id,
            'company_address_en'=> 'nullable|min:2',
            'company_address_ar'=> 'nullable|min:2',
            'map'               => 'nullable|min:2',
            'facebook'          => 'nullable|min:2',
            'insta'             => 'nullable|min:2',
            'twitter'           => 'nullable|min:2',
            'youtube'           => 'nullable|min:2',
            'linkedin'          => 'nullable|min:2',
            'pri_contact_name'  => 'nullable|min:2',
            'pri_contact_phone' => 'nullable|min:2',
            'pri_contact_email' =>'required|email|unique:companies,pri_contact_email,'.$id,
            'brochure'          => 'nullable|mimes:pdf|max:10000000',
            'price_lists'       => 'nullable|mimes:pdf|max:10000000',
        ];
    }
}
