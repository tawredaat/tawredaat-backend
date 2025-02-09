<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;
use App\Models\Area;
use App\Models\Brand;
use App\Models\CompanyType;
use Illuminate\Validation\Rule;
class FilterCompanyRequest extends FormRequest
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
            
            'areas'=>'nullable|',
            'areas.*'=>[Rule::in(Area::pluck('id'))],

            'brands'=>'nullable|',
            'brands.*'=>[Rule::in(Brand::pluck('id'))],

			'type'=>'nullable|',
            'types.*'=>[Rule::in(CompanyType::pluck('id'))]
        ];
    }
}
