<?php

namespace App\Http\Controllers\Api\Auth;

use App\Customs\Services\EmailVerificationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteRegistrationRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private EmailVerificationService $service)
    {

    }
    public function register(RegistrationRequest $request)
    {
        $validatedData = $request->validated();


        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'password' => '1234aA!4',
            'role_id' => 0,
            'status' => 0,
        ]);

        $organization= Organization::create([
            'name' => $validatedData['organization_name'],
            'user_id' => $user->id,
            'package_id' => 0,
        ]);

        if($user && $organization){
            $this->service->sendVerificationLink($user);
            $token = auth()->login($user);
            return response()->json([
               'status' => 'success',
               'user' => $user,
               'organization' => $organization,
               'access_token' => $token,
               'type' => 'Bearer',
            ]);
        }
        else{
            return response()->json([
               'status' => 'failed',
               'message' => 'Registration failed',
            ],500);
        }
    }
    public function completeRegister(CompleteRegistrationRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::findOrFail($validatedData['user_id']);
        $organization = Organization::findOrFail($validatedData['organization_id']);

        if(!($user->email_verified_at)){
            return response()->json([
               'status' => 'failed',
               'message' => 'You cannot continue registration as your email is not verified',
            ]);
        }

        // Update user data
        $user->update([
            'password' => bcrypt($validatedData['password']),
        ]);

        // Update organization data
        $organization->update([
            'commercial_register_number' => $validatedData['commercial_register_number'] ,
            'tax_card_number' => $validatedData['tax_card_number'] ,
            'users_count' => $validatedData['users_count'] ,
            'revisers_count' => $validatedData['revisers_count'] ,
        ]);

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'organization' => $organization,
        ]);
    }

    public function verifyUserEmail(VerifyEmailRequest $request)
    {
        return $this->service->verifyEmail($request->email,$request->token);
    }

}
