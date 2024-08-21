<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Api\Auth\AuthController;
use Tymon\JWTAuth\Http\Parser\AuthHeaders;

class StatusRequest extends FormRequest
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
        $user =User::find(request()->id);
        return [
            'status' => ['required' , 'boolean' , 'in:0,1' , function($attribute, $value, $fail) use ($user)
            {
                if ($user->status == $value)
                {
                    $fail('You cannot change the status to the same status');
                }
            }
            ]
                ];


    }
}
