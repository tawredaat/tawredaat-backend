<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
            'name_ar'=>'required|string|min:2|max:191',
            'name_en'=>'required|string|min:2|max:191',
            'durationInMonth'=>'required|integer|min:1',
            'price'=>'required|integer|min:1',
            'rank_points'=>'required|integer|min:1',
            'visibility'=>'required|boolean'
        ];
    }
}
