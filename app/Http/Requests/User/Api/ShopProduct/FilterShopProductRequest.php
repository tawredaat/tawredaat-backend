<?php

namespace App\Http\Requests\User\Api\ShopProduct;

use App\Models\Category;
use App\Rules\CorrectCategoryLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterShopProductRequest extends FormRequest
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
            'search_key' => 'nullable|string',

            'categories' => 'nullable',
            'categories.*' => [Rule::in(Category::where('level', 'level3')->pluck('id'))],

            'brands' => 'nullable',
            'brands.*' => 'exists:brands,id',

            'countries' => 'nullable',
            'countries.*' => 'exists:countries,id',

            'companies' => 'nullable',
            'companies.*' => 'exists:companies,id',

            // specifications // ShopProductSpecification
            'specifications' => 'nullable',
            'specifications.*' => 'exists:shop_product_specifications,id',

            'from' => 'nullable|numeric|lte:to',
            'to' => 'nullable|numeric|gte:from',

            'in_brand' => 'nullable|exists:brands,id',

            // in_company not used
            'in_company' => 'nullable|exists:companies,id',

            'in_category' => 'nullable|exists:categories,id|required_if:category_level,level1|required_if:category_level,level2||required_if:category_level,level3',

            // this field required in category, and the category level had to be correct
            // meaning if in_category is a level1 category, the value of category_level has to be level1
            'category_level' => ['nullable', 'in:level1,level2,level3',
                new CorrectCategoryLevel($this->in_category)],

        ];
    }
}
