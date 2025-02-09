<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTypeRequest extends FormRequest
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
            'company_types'=>'required|array',
            'company_types.*'=>[
                            'required',
                            'distinct',
                            'exists:company_types,id',
                            Rule::notIn(auth('company')->user()->company_types->pluck('id'))
                        ]
        ];
    }
}
