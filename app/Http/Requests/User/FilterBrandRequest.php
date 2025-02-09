<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Validation\Rule;
class FilterBrandRequest extends FormRequest
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
        	'categories'=>'nullable|',
            'categories.*'=>[Rule::in(Category::where('level','level3')->pluck('id'))],
            
            'countries'=>'nullable|',
            'countries.*'=>[Rule::in(Country::pluck('id'))],

            'companies'=>'nullable|',
            'companies.*'=>[Rule::in(Company::where('hidden',1)->pluck('id'))]
        ];
    }
}
