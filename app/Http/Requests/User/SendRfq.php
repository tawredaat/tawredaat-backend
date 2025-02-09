<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SendRfq extends FormRequest
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
            'category_id' => 'required|array',
            'category_id.*' => 'required|exists:categories,id',
            'description'   => 'required|array',
            'description.*' => 'required|string|min:1|max:99999',
            'quantity'   => 'required|array',
            'quantity.*' => 'required|integer|max:99999.99',
            'terms'=>'required|accepted',
            'policy'=>'required|accepted',
        ];
    }
}
