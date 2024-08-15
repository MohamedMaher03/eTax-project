<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'organization_name' => ['required', 'string', 'min:1','max:255'],
            'name' => ['required', 'string', 'min:2','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           // 'password' => ['required', 'string', 'min:8', 'confirmed','max:255','regex:/[a-z]/','regex:/[A-Z]/','regex:/[0-9]/', 'regex:/[\W]/'],
            'phone' =>['sometimes', 'string', 'min:11','max:11','nullable'],
        ];
    }
}
