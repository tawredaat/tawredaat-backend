<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|alpha|min:3|max:191',
            'last_name' => 'required|alpha|min:3|max:191',
            'phone' => ['required', 'unique:users', 'regex:/(01)[0-9]{9}/'],
            'password' => 'required|string|min:6|max:14',
            'email' => 'required|email|unique:users|min:2|max:191',
            'title' => 'nullable|string|min:2|max:191',
            'company_name' => 'nullable|string|min:2|max:191',
            'photo' => 'required|' . ValidateImage(),
        ];
    }
}
