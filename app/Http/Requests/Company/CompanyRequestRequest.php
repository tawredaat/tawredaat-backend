<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequestRequest extends FormRequest
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
            'name'   =>'required|string|max:191',
            'company_name'   =>'required|string|max:191',
            'company_type'   =>'nullable|string|max:191',
            'website'   =>'nullable|url|max:191',
            'facebook'   =>'nullable|url|max:191',
            'email'     =>'required|email|unique:company_requests|max:191',
            'phone'     =>'nullable|numeric|unique:company_requests',
            'mobile'     =>'required|numeric|unique:company_requests',
        ];
    }
}
