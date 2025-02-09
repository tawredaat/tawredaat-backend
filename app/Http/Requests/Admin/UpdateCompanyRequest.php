<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class UpdateCompanyRequest extends FormRequest
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
            'logo'              => 'nullable|'.ValidateImage(),
            'mobilecover'              => 'nullable|'.ValidateImage(),
            'alt_en'            => 'required|min:2|string|max:191',
            'alt_ar'            => 'required|min:2|string|max:191',
            'name_en'           => 'required|min:2|string|max:191',
            'name_ar'           => 'required|min:2|string|max:191',
            'title_en'          => 'nullable|min:2|string|max:573',
            'title_ar'          => 'nullable|min:2|string|max:573',
            'descri_en'         => 'nullable|min:2|string|max:65533',
            'descri_ar'         => 'nullable|min:2|string|max:65533',
            'descri_meta_en'    => 'nullable|min:2|string|max:65533',
            'descri_meta_ar'    => 'nullable|min:2|string|max:65533',
            'keyword_meta_en'   => 'nullable|min:2|string|max:65533',
            'keyword_meta_ar'   => 'nullable|min:2|string|max:65533',
            'keyword_en'        => 'nullable|min:2|string',
            'keyword_ar'        => 'nullable|min:2|string',
            'date'              => 'nullable|min:2',
            'sales_mobile'      => 'nullable|min:2',
            'company_phone'     => 'nullable|min:2',
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
            'products_title_en'=>'nullable|string|min:2|max:191',
            'products_title_ar'=>'nullable|string|min:2|max:191',
            'products_description_en'=>'nullable|string|min:2|max:65533',
            'products_description_ar'=>'nullable|string|min:2|max:65533',
            'products_keywords_en'=>'nullable|string|min:2|max:65533',
            'products_keywords_ar'=>'nullable|string|min:2|max:65533'
        ];
    }
}
