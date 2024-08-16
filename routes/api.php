<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/register', [AuthController::class,'register']);

Route::post('auth/verify-user-email', [AuthController::class,'verifyUserEmail'])->name('verify.email');

Route::post('auth/complete-register', [AuthController::class,'completeRegister']);



