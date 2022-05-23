<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'command' => 'required',
            'firm_name' => 'required',
            'firm_address' => 'required',
            'firm_phone' => 'required',
            'firm_year' => 'required',
            'document' => 'file',
        ];
    }
}
