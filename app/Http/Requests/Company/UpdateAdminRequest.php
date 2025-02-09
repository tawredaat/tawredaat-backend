<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
         $id = $this->route('admin');
        return [
            'name_en'      =>'required|max:191',
            'email'     =>'required|email|unique:company_admins,email,'.$id,
            'password'  =>'nullable|min:6|max:191',
            'phone'     =>'required|numeric',
        ];
    }
}
