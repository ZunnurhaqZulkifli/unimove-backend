<?php

use App\Http\Controllers\Api\AcceptOrderApi;
use App\Http\Controllers\Api\BiometricUserApiController;
use App\Http\Controllers\Api\DeleteUserApi;
use App\Http\Controllers\Api\GetDestinationsApi;
use App\Http\Controllers\Api\LoginUserApi;
use App\Http\Controllers\Api\LogoutUserApi;
use App\Http\Controllers\Api\OrderRideApi;
use App\Http\Controllers\Api\ProfileUserApi;
use App\Http\Controllers\Api\RegisterUserApi;
use App\Http\Controllers\Api\TacApiController;
use App\Http\Controllers\Api\UpdateUserApiController;
use App\Http\Controllers\Api\UpdateUserBiometricApi;
use App\Http\Controllers\Api\UpdateUserProfileApi;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('/check', function () {
        $data = [
            'message' => 'Welcome to Unimove Api',
            'status' => 'we have lift off ! 🚀🚀🚀',
        ];
    
        return response($data, 200);
    });

    Route::post('register', [RegisterUserApi::class, 'register'])->name('register');
    Route::post('login', [LoginUserApi::class, 'login'])->name('login');
    Route::post('request-tac', [TacApiController::class, 'sendTac'])->name('request-tac');
    Route::get('destinations', [GetDestinationsApi::class, 'index'])->name('destinations');
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {

    // user controller / user profile / auth controller
    Route::post('profile', [ProfileUserApi::class, 'profile'])->name('profile');
    Route::post('update-user', [UpdateUserApiController::class, 'update'])->name('update-user');
    Route::post('update-profile', [UpdateUserProfileApi::class, 'update'])->name('update-profile');
    Route::post('update-biometric', [UpdateUserBiometricApi::class, 'update'])->name('update-biometric');
    Route::get('user-biometric', [BiometricUserApiController::class, 'biometric'])->name('user-biometric');

    // destination / booking controller
    Route::post('order-ride', [OrderRideApi::class, 'order'])->name('order-ride');
    Route::post('accept-order', [AcceptOrderApi::class, 'accept'])->name('accept-order');

    Route::post('logout', [LogoutUserApi::class, 'logout'])->name('logout');
  Route::post('delete-user', [DeleteUserApi::class, 'delete'])->name('delete-user');
});