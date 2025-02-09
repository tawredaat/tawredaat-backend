<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'name'      =>'required|alpha|min:3|max:9',
            'email'     =>'required|email|unique:admins|max:191',
            'password'  =>'required|string|min:6|max:14',
            'privilege' =>'required|in:cs,super,manager'
        ];
    }
}
