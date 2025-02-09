<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use App\Rules\ValidCartItemQuantity;
class StoreCartItemRequest extends FormRequest
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
            'shopProductId' => 'required|integer|exists:shop_products,id',
            // 'companyId' => 'nullable|integer|exists:companies,id',
            'quantity' => ['required', 'numeric', 'max:99999.99', new ValidCartItemQuantity($this->input('shopProductId'))],
        ];
    }


}
