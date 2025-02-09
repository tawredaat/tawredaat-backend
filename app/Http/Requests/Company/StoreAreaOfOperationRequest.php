<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAreaOfOperationRequest extends FormRequest
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
            'areas'=>'required|array',
            'areas.*'=>[
                            'required',
                            'distinct',
                            'exists:areas,id',
                            Rule::notIn(auth('company')->user()->areas->pluck('id'))
                        ]
        ];
    }
}
