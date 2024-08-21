<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StatusRequest;

class UserStatusController extends Controller
{
    public function changeStatus (StatusRequest $request){
        // get user
        //validate status request not user status
        $user = User::find($request->id);
        // change user status
       $user->status = !$user->status;
        $user->save();
        return response()->json([
            'status' => $user->status]);


    }
}
