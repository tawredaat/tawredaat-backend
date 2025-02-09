<?php

namespace App\Http\Requests\User\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class CreateUserRequest extends FormRequest
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
            // 'name' => 'nullable|string|regex:/^[\pL\s\-]+$/u|max:50',
            // 'last_name' => 'nullable|string|regex:/^[\pL\s\-]+$/u|max:50',
            'full_name' => 'required|string|regex:/^[\pL\s\-]+$/u|max:50',   
            'user_type' => 'required|in:consumer,company,technician',
            'phone' => 'required|regex:/^\+?\d+$/|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            // 'interest_id' => 'nullable|array',
            // 'interest_id.*' => 'nullable|exists:interests,id',
            // 'T' => 'nullable|string|max:191', //title
            // 'CN' => 'nullable|string|max:191', //company name
            // 'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,webp',
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
