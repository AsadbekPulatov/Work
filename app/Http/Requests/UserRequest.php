<?php

namespace App\Http\Requests;

use App\Rules\PassportNumber;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'=>'required',
            'email'=>'required |email|unique:users',
            'password'=>'required | min:8',
            'password_confirm'=>'required_with:password|same:password',
            'phone'=>['required',new PhoneNumber()],
            'address'=>'required',
            'passport'=>['required',new PassportNumber()],
            'surname'=>'required',
            'father_name'=>'required',
            'sana'=>'required'
        ];
    }
}
