<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\AddNewUserRequest;

class AddNewUser extends Controller
{

    public function addUser(AddNewUserRequest $request){

        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'password' => $validatedData['password'],
            'role_id' => $validatedData['role_id'],
            'status' => $validatedData['status'],
        ]);
        
        if($user){
            return response()->json([
                'status'=> 'success',
                'message'=> 'User Added Successfully',
            ]);
        }else{
            return response()->json([
                'status'=> 'error',
                'message'=> 'There was a problem in the data entered please try again',
            ]);
        };
    }
}