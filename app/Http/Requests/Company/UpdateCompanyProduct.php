<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProduct extends FormRequest
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
             'unit_id'  =>'nullable|exists:units,id',
             'Price'    =>'nullable|string|max:191',
             'qty'      =>"nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/",
             'discount' =>"nullable|regex:/^[0-9]+(\.[0-9][0-9]?)?$/",
        ];
    }
}
