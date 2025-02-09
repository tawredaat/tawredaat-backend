<?php

namespace App\Http\Requests\User\Api\Survey;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SurveyRequest extends FormRequest
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
            'user_id' => 'required|numeric|exists:users,id',
            'order_id' => ['required', 'numeric',
                Rule::exists('orders', 'id')
                    ->where('user_id', $this->user_id)
                    ->where('order_status_id', config('global.delivered_order_status', 4)),
            ],
            'finding_ease_score' => 'required|numeric',
            'usage_problems_score' => 'required|numeric',
            'usage_problems_explanation' => 'nullable|string',
            'shipping_time_score' => 'required|numeric',
            'product_quality_delivery_time_score' => 'required|numeric',
            'courier_score' => 'required|numeric',
        ];
    }

    /*
     * overwrite response in form request parent class
     */
    protected function failedValidation(Validator $validator)
    {
        if (in_array('api', explode('/', $this->path()))) {
            $response['code'] = 101;
            $response['message'] = "Validation Errors";
            $response['validation'] = $validator->errors()->all();
            $response['item'] = 0;
            $response['data'] = null;
            throw new HttpResponseException(response()->json($response, 200));
        }
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
