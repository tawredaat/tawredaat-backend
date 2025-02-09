<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateUserRequest extends FormRequest
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
        $id = $this->route('user');
        return [
            'name' => 'required|alpha|min:3|max:191',
            'last_name' => 'required|alpha|min:3|max:191',
            'password' => 'nullable|string|min:6|max:14',
            'phone' => ['required', 'regex:/(01)[0-9]{9}/', 'unique:users,phone,' . $id],
            'email' => 'required|email|unique:users,email,' . $id,
            'title' => 'nullable|string|min:2|max:191',
            'company_name' => 'nullable|string|min:2|max:191',
            'photo' => 'nullable|' . ValidateImage(),
        ];
    }
}
