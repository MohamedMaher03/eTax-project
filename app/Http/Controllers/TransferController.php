<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\UserReviser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role ;
use App\Http\Requests\TransferRequest;

class TransferController extends Controller
{
    public function transfer(TransferRequest $request)
    {
         // get user
     $admin = auth()->user();
     $organization = Organization::where('user_id' , $admin->id)->first();
     $balance = $request->balance;

     $userId = $request->userId;

     $user = User::find($userId);
        if (!$user){
        return response()->json(['message' => 'failed']);
    }
     $userReviser = UserReviser::where('user_id' , $user->id)->first();

         // subtract from admin
         $organization->operations_count -=  $balance;
         $organization->save();
         // add user balance
         $userReviser->balance +=  $balance;
         $userReviser->save();
         return response()->json(['message' => 'Transfer successful']);



    }
}





