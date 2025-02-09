<?php

namespace App\Http\Requests\Admin\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'responsible_person_email' => ['required', 'email', 'max:191'
                , Rule::unique('vendors', 'responsible_person_email')
                    ->ignore($this->id)],
            'company_type' => 'required|in:contractor,seller,electrician',
            'commercial_license' => 'nullable|mimes:pdf,png,jpg',
            'tax_number_certificate' => 'nullable|mimes:pdf,png,jpg',
            'added_value_certificate' => 'nullable|mimes:pdf,png,jpg',
            'contractors_association_certificate' => 'nullable|mimes:pdf,png,jpg',
            'logo' => 'nullable|image',
            'is_approved' => 'nullable',
        ];
    }
}
