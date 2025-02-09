<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidCompanyId;
use App\Rules\ValidSubscriptionId;
use Illuminate\Foundation\Http\FormRequest;

class AssignSubscriptionRequest extends FormRequest
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
            'companyId' => ['required','integer', new ValidCompanyId()],
            'subscriptionId' => ['required','integer', new ValidSubscriptionId()]
        ];
    }
}
