<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\UserReviser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role ;

class TransferController extends Controller
{
    public function transfer(Request $request )
    {
         // get user
     $admin = auth()->user();
     $organization = Organization::where('user_id' , $admin->id)->first();
     $balance = $request->route('balance') ;
     // validation
     if ($balance> $organization -> operations_count){
         return response()->json(['message' => 'failed']);
     }
     $userId = $request->route('userId');

     $user = User::find($userId);
     $userReviser = UserReviser::where('user_id' , $user->id)->first();
     // validation
     if (!$userReviser){
         return response()->json(['message' => 'failed']);}
         // subtract from admin
         $organization->operations_count -=  $balance;
         $organization->save();
         // add user balance
         $userReviser->balance +=  $balance;
         $userReviser->save();
         return response()->json(['message' => 'Transfer successful']);



    }
}





