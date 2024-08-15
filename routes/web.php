<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'hello';
});


Route::post('auth/complete-register', [AuthController::class,'completeRegister']);
