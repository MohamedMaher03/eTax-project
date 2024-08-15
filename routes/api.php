<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\TransferController;
use App\Models\User;
use App\Models\Packages;
use App\Models\User_reviser;
use App\Models\Role;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/register', [AuthController::class,'register']);
Route::get('/package', [PackageController::class, 'getAllData']);
Route::post('/user/status', [UserStatusController::class, 'changeStatus']);
Route::post('/transfer', [TransferController::class, 'transfer']);




Route::post('auth/verify-user-email', [AuthController::class,'verifyUserEmail']);

Route::post('auth/complete-register', [AuthController::class,'completeRegister']);



