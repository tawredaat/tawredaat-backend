<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandTypeRequest extends FormRequest
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
            // 'company_type_ids'      =>'required|exists:company_types,id',
            "company_type_id"    => "required|array|min:1",
            "company_type_id.*"  => "required|exists:company_types,id",
        ];
    }
}
