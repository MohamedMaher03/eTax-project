<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddNewUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:255','regex:/[a-z]/','regex:/[A-Z]/','regex:/[0-9]/', 'regex:/[\W]/'],
            'phone' =>['sometimes', 'string', 'min:11','max:11','nullable'],
            'role_id' => ['required', 'integer'],
            'status' =>['required', "integer","in:0,1"],
        ];
    }
}
