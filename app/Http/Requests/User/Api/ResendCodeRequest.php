<?php

namespace App\Http\Requests\User\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResendCodeRequest extends FormRequest
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
            'userId' => 'required|integer|exists:users,id',
        ];
    }

    /*
    * overwrite response in form request parent class
    */
    protected function failedValidation(Validator $validator) {
        $response['code'] = 101;
        $response['message'] = "Validation Errors";
        $response['validation'] = $validator->errors()->all();
        $response['item'] = 0;
        $response['data'] = null;
        throw new HttpResponseException(response()->json($response, 200 ));
    }
}
