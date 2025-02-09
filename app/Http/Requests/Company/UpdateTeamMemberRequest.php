<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamMemberRequest extends FormRequest
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
            'name_en'      =>'required|string|max:191',
            'name_ar'      =>'required|string|max:191',
            'title_en'     =>'required|string|max:191',
            'title_ar'     =>'required|string|max:191',
            'image'        =>'nullable|'.ValidateImage(),
            'alt_en'       =>'nullable|string|max:191',
            'alt_ar'       =>'nullable|string|max:191'
        ];
    }
}
