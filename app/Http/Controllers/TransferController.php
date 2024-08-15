<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\UserReviser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role ;

class TransferController extends Controller
{
    public function transfer(Request $request)
    {
        //validations


        $admin = User::where('role_id', 2)->first();   //


        $user = User::find($request->id);

//        $organization=Organization::where('user_id',$admin->id)->first();
//        $user_reviser=UserReviser::where('user_id',$user->id)->first();

        // DB::beginTransaction();
        // Balance deduction = 100 from admin

        $organization->operations_count -= $request->balance;
        $organization->save();
        // add new balance = 100 to user
        $user_reviser->balance += 100;
        $user_reviser->save();

        //DB::commit();

            return response()->json(['message' => 'Transfer successful']);

       // DB::rollBack();
       // return response()->json(['error' => 'Transfer failed']);
    }
}





