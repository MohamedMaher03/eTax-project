<?php

namespace App\Http\Requests;

use App\Models\Organization;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Models\User;
use Tymon\JWTAuth\Http\Parser\AuthHeaders;

class TransferRequest extends FormRequest
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
        $admin = auth()->user();

        $orgnization = Organization::where('user_id', $admin->id)->first();

        if (!$orgnization)
        {
            return response()->json(['message' => 'failed']);
        }
        return [

            'balance' =>['required' , 'numeric' , 'min :1'   , function($attribute, $value, $fail) use ($orgnization)
            {
                if ($value > $orgnization->operations_count)
                {
                    $fail('Your current balance is insufficient to complete this operation.');
                }
            }
            ]

        ];


    }
}




