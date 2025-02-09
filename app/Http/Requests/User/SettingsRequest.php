<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
        $id = UserID();
        return [
            'name'             => 'required|',
            'email'     	   => 'required|email|max:191|unique:users,email,'.$id,
            'T'            	   => 'required|',
            'CN'     		   => 'required|',
            'phone'     	   => 'required|string|max:191|unique:users,phone,'.$id,
            'photo'            => 'nullable|image',
        ];
    }
}
