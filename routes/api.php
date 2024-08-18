<?php

use App\Http\Controllers\PackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\TransferController;
use App\Http\Requests\StatusRequest;
use App\Http\Requests\TransferRequest;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/register', [AuthController::class,'register']);
Route::get('/package', [PackageController::class, 'getAllpackage']);
Route::post('/user/status', [UserStatusController::class, 'changeStatus']);
Route::post('/transfer', [TransferController::class, 'transfer'])->middleware(['role:1']);

Route::post('/auth/login', [AuthController::class,'login']);
Route::post('/auth/logout', [AuthController::class,'logout'])->middleware('auth');
Route::post('/auth/newUser', [AuthController::class,'addUser']);


Route::post('auth/verify-user-email', [AuthController::class,'verifyUserEmail'])->name('verify.email');

Route::post('auth/complete-register', [AuthController::class,'completeRegister']);

Route::patch('buy/package/{id}',[PackageController::class,'buyPackage'])->middleware('role:1',)->name('buy.package');

