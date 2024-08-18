<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Package;
use App\Models\UserReviser;
use Faker\Factory as Faker;
use App\Http\Requests\AddNewUserRequest;
use App\Customs\Services\EmailVerificationService;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteRegistrationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\Organization;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ApiResponse;

class AuthController extends Controller
{
    private EmailVerificationService $service;
    public function __construct(private EmailVerificationService $servic)
    {
        $this->service = $servic;
    }

    public function login(LoginRequest $request){

        try{
            if (! $token = auth('api')->attempt($request->validated())) {
                return response()->json(['error' => 'Either email or password is wrong.'], 401);
            }
    
            return $this->createNewToken($token);
        }catch(\Exception $e){
            return ApiResponse::generalError();
        }
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

        $admin_role_id=Role::where('name','admin')->first()->id;
        //make status is 0 by default in database  (optional)
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'password' => bcrypt('1234aA!4'),
            'role_id' => $admin_role_id,
            'status' => 0,
        ]);

        // make package_id nullable by default  (required)
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

        if(!($user->email_verified_at)){
            return response()->json([
                'status' => 'failed',
                'message' => 'You cannot continue registration as your email is not verified',
            ],400);
        }

        $organization = Organization::where('user_id', $user->id)->firstOrFail();



        $user->update([
            'password' => bcrypt($validatedData['password']),
        ]);

        //$operations_count=(Package::where('id',$validatedData['package_id']))->value('operations_count');
        $operations_count=Package::find($validatedData['package_id'])->operations_count;
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
         //move it outside function  (required)
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

    public function logout()
    {
        try{
            auth('api')->logout();
            return response()->json(['message' => 'Successfully logged out']);
        }catch (\Exception $e){
            return ApiResponse::generalError();
        }
    }

    public function addUser(AddNewUserRequest $request){

        try{
            $validatedData = $request->validated();
            $roleId= $validatedData['role_id'];
    
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'] ?? null,
                'password' => bcrypt($validatedData['password']),
                'role_id' => $roleId,
                'status' => $validatedData['status'],
            ]);
    
            if($user){
                return ApiResponse::success("A new user was added successfully");
                if($roleId == 2){
                    UserReviser::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'phone' => $validatedData['phone'] ?? null,
                    'password' => bcrypt($validatedData['password']),
                    'status' => $validatedData['status'],
                    ]);
                }
            }else{
                return ApiResponse::validationError("An error validating data occurred please try again");
            };
    
        }catch (\Exception $e){
            return ApiResponse::generalError();
        };
    }
}
