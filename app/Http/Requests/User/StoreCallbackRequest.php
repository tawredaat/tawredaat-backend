<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Validation\Rule;
class StoreCallbackRequest extends FormRequest
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
            'companyID' =>'required|',[Rule::in(Company::where('hidden',1)->pluck('id'))],
        ];
    }
}
