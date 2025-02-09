<?php

namespace App\Http\Requests\User\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;


class StoreRFQRequest extends FormRequest
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
            'user_name'   => 'required|max:255',
            'phone' => 'required',
            'email'   => 'required|email',
            'sender_type' => 'required',
            'company_name'=> 'string',
            'description' => 'string|max:2000',
            'rfq_type' => 'string|max:255',
            'attachments' => 'sometimes',
            'city_id' => 'required|exists:cities,id',
        ];
    }
}
