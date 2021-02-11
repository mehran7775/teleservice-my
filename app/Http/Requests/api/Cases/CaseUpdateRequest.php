<?php

namespace App\Http\Requests\api\cases;

use Illuminate\Foundation\Http\FormRequest;

class CaseUpdateRequest extends FormRequest
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
            'full_name' => 'required|min:6,max:25',
            'number_meli' => 'required|digits:10',
            'category' => 'required',
            'caseFile' =>'file|mimes:pdf',
            'expired_at' => 'required|date_format:H:i',
        ];
    }
}
