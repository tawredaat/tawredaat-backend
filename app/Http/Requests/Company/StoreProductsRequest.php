<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\CompanyProduct;
class StoreProductsRequest extends FormRequest
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
            'brand_id'   => 'required|exists:brands,id',
            'products'   => 'required|array',
            'products.*' => ['required','distinct',Rule::notIn(CompanyProduct::where('company_id',auth('company')->user()->id)->pluck('product_id'))],

        ];
    }
}
