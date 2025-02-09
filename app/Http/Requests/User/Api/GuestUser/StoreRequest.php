<?php

namespace App\Http\Requests\User\Api\GuestUser;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
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
            'id' => 'required|exists:guest_users,id',
            'first_name' => 'required|string|min:3|max:191',
            'last_name' => 'required|string|min:3|max:191',
            'email' => 'required|email|min:3|max:191',
            'phone' => 'required|regex:/^\+?\d+$/|max:15',
            'company_name' => 'nullable|string|min:3|max:191',
            'country_or_region' => 'nullable|string|min:3|max:191',
            'street_address_first_line' => 'required|string|min:3|max:191',
            'street_address_second_line' => 'required|string|min:3|max:191',
            'town_or_city' => 'required|string|min:3|max:191',
            'state_or_country_id' => 'required|exists:cities,id',
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
