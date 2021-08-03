<?php

namespace EOffice\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nama' => 'required',
            'username' => 'required',
            'email' => 'unique:users|email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages(){
        return [];
    }
}
