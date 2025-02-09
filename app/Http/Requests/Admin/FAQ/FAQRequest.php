<?php

namespace App\Http\Requests\Admin\FAQ;

use Illuminate\Foundation\Http\FormRequest;

class FAQRequest extends FormRequest
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
            'content_en' => 'required|string|min:2',
            'content_ar' => 'required|string|min:2',
        ];
    }
}
