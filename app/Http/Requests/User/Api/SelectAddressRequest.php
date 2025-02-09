<?php

namespace App\Http\Requests\User\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class SelectAddressRequest extends FormRequest
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
            'address_id' => 'required|integer|exists:user_addresses,id',
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
