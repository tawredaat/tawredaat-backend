<?php

namespace App\Http\Requests\User\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;


class StoreSupplierRequest extends FormRequest
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
            'category_name'   => 'required|max:255',
            'city_id' => 'required|exists:cities,id',
            'full_name'   => 'required|max:255',
            'phone' => 'required|max:11',
            'email'=> 'sometimes|email',
        ];
    }
}
