<?php

namespace App\Http\Requests\User\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class SearchRequest extends FormRequest
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
            'search_key'            => 'nullable|string',
            'brands'   => 'nullable|array',
            'brands.*' => 'nullable|integer|exists:brands,id',
            'categories'   => 'nullable|array',
            'categories.*' => 'nullable|integer|exists:categories,id',
            'countries'   => 'nullable|array',
            'countries.*' => 'nullable|integer|exists:countries,id',
            'companies'   => 'nullable|array',
            'companies.*' => 'nullable|integer|exists:companies,id',
            'specifications'   => 'nullable|array',
            'specifications.*' => 'nullable|integer|exists:specifications,id',
            'areas'   => 'nullable|array',
            'areas.*' => 'nullable|integer|exists:areas,id',
            'types'   => 'nullable|array',
            'types.*' => 'nullable|integer|exists:company_types,id',
        ];
    }

    /*
    * overwrite response in form request parent class
    */
    protected function failedValidation(Validator $validator)
    {
        if (in_array('api', explode('/', $this->path()))) {
            $response['code'] = 101;
            $response['message'] = "Validation Errors";
            $response['validation'] = $validator->errors()->all();
            $response['item'] = 0;
            $response['data'] = null;
            throw new HttpResponseException(response()->json($response, 200));
        }
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
