<?php

namespace App\Http\Controllers\Api\Auth;
use App\Models\EmailVerficationToken;
use App\Models\Package;
use App\Models\UserReviser;
use Faker\Factory as Faker;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteRegistrationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\Organization;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
<<<<<<< HEAD


    public function __construct() {
        
=======
    private EmailVerificationService $service;
    public function __construct(private EmailVerificationService $servic)
    {
        $this->service = $servic;
>>>>>>> 3905cf792964597678f6b6b782372ccb28accc7d
    }

    public function login(LoginRequest $request){

        if (! $token = auth('api')->attempt($request->validated())) {
            return response()->json(['error' => 'Either email or password is wrong.'], 401);
        }

        return $this->createNewToken($token);
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => auth('api')->user(),
        ]);
    }

    public function register(RegistrationRequest $request)
    {
        $validatedData = $request->validated();


        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'password' => '1234aA!4',
            'role_id' => 1,
            'status' => 0,
        ]);

        $organization= Organization::create([
            'name' => $validatedData['organization_name'],
            'user_id' => $user->id,
            'package_id' => 1,
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

        $user = User::where('email', $validatedData['email'])->firstOrFail();
        $organization = Organization::where('user_id', $user->id)->firstOrFail();


        if(!($user->email_verified_at)){
            return response()->json([
               'status' => 'failed',
               'message' => 'You cannot continue registration as your email is not verified',
            ],400);
        }

        $user->update([
            'password' => bcrypt($validatedData['password']),
        ]);

        $operations_count=(Package::where('id',$validatedData['package_id']))->value('operations_count');

        $organization->update([
            'commercial_register_number' => $validatedData['commercial_register_number'] ,
            'tax_card_number' => $validatedData['tax_card_number'] ,
            'users_count' => $validatedData['users_count'] ,
            'revisers_count' => $validatedData['revisers_count'] ,
            'package_id' => $validatedData['package_id'] ,
            'operations_count' => $operations_count,
        ]);

        $faker = Faker::create();

        $prefixes = ['010', '011', '012', '015'];

        function generatePhoneNumber($prefixes, $faker) {
            return $faker->randomElement($prefixes) . $faker->numerify('########');
        }

        for ($i = 0; $i < $validatedData['users_count']; $i++) {
            $createdUser= User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => bcrypt('1234aA!4'),
                'phone' => generatePhoneNumber($prefixes, $faker),
                'status' => 0,
                'role_id' => 3,
            ]);

            UserReviser::create([
                'user_id' => $createdUser->id,
                'balance' => 0,
                'organization_id' => $organization->id,
            ]);
        }

        for ($i = 0; $i < $validatedData['revisers_count']; $i++) {
            $createdReviser=User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => bcrypt('1234aA!4'),
                'phone' => generatePhoneNumber($prefixes, $faker),
                'status' => 0,
                'role_id' => 2,
            ]);
            UserReviser::create([
                'user_id' => $createdReviser->id,
                'balance' => 0,
                'organization_id' => $organization->id,
            ]);
        }


        return response()->json([
            'status' => 'success',
            'user' => $user,
            'organization' => $organization,
        ],200);
    }

    public function verifyUserEmail(VerifyEmailRequest $request)
    {
        //return $result=EmailVerificationService::verifyEmail($request->email,$request->token);
        //return response()->json($result, $result['status_code']);
        return $this->service->verifyEmail($request->email, $request->token);

    }

}
