<?php

namespace App\Http\Requests\api\Cases;

use Illuminate\Foundation\Http\FormRequest;

class CaseRequest extends FormRequest
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
            'fullNameSick' => 'required|min:6,max:25',
            'meliNumber' => 'required|digits:10',
            'category' => 'required',
            'caseFile' =>'required|file|mimes:pdf',
            'time' => 'required|date_format:H:i'
        ];
    }
}
