<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePricesExcel extends FormRequest
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
        //please don't remove txt from validation , because csv work only with txt
        return [
            'file' => 'required|mimes:csv,txt|max:10000000',
        ];
    }

    public function messages()
    {
        return [
            'file.mimes' => 'Only CSV files are supported',
        ];
    }
}
