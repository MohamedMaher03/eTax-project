<?php

use App\Http\Controllers\PackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\LoadingController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\TransferController;
use App\Http\Requests\StatusRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Middleware\HandleCors;


Route::options('/{any}', function () {
    return response()->json([], 200);
})->where('any', '.*');


Route::post('auth/verify-user-email', [AuthController::class, 'verifyUserEmail'])->name('verify.email');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/register', [AuthController::class, 'register']);
Route::get('/package', [PackageController::class, 'getAllpackage']);
Route::post('/user/status', [UserStatusController::class, 'changeStatus'])
    ->middleware(['auth', 'admin']);
Route::post('/transfer', [TransferController::class, 'transfer'])
    ->middleware(['auth', 'admin']);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::post('/auth/newUser', [AuthController::class, 'addUser']);

Route::post('/auth/login', [AuthController::class,'login']);
Route::post('/auth/logout', [AuthController::class,'logout'])->middleware('auth');
Route::post('/auth/newUser', [AuthController::class,'addUser']);
Route::get('/getControllers/{key?}', [GetDataController::class,'getConfigbyKey']);
Route::get('/resource', [LoadingController::class, 'getResource']);




Route::get('register-data/{token}', [AuthController::class, 'getRegisterData']);

Route::post('auth/complete-register', [AuthController::class, 'completeRegister']);

Route::patch('buy/package/{id}', [PackageController::class, 'buyPackage'])
    ->middleware(['auth', 'admin'])
    ->name('buy.package');

