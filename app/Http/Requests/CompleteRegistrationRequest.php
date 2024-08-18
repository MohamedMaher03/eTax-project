<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteRegistrationRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[\W]/', 'confirmed',],
            'commercial_register_number' => ['required', 'integer','unique:organizations,commercial_register_number', 'digits:9'],
            'tax_card_number' => ['required', 'integer', 'digits_between:6,20'],
            'users_count' => ['required', 'integer','digits_between:1,20'],
            'revisers_count' => ['required', 'integer','digits_between:1,20'],
            'package_id'=>['required', 'integer', 'exists:packages,id'],
        ];
    }
}
