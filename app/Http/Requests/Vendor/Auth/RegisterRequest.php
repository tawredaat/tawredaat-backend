<?php

namespace App\Http\Requests\Vendor\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'company_name' => 'required|string',
            'responsible_person_name' => 'required|string',
            'responsible_person_mobile_number' => 'required|numeric',
            'responsible_person_email' => 'required|email|max:191|unique:vendors,responsible_person_email',
            'password' => 'required|string',
            'company_type' => 'required|in:contractor,seller,electrician',
            'commercial_license' => 'required|mimes:pdf,png,jpg',
            'tax_number_certificate' => 'required|mimes:pdf,png,jpg',
            'added_value_certificate' => 'nullable|mimes:pdf,png,jpg',
            'contractors_association_certificate' => 'nullable|mimes:pdf,png,jpg',
            'logo' => 'required',
        ];
    }
}
