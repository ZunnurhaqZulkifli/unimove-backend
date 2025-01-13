<?php

use App\Http\Controllers\Api\AcceptOrderApi;
use App\Http\Controllers\Api\BiometricUserApiController;
use App\Http\Controllers\Api\CalculateDataApi;
use App\Http\Controllers\Api\CheckHasBooking;
use App\Http\Controllers\Api\CheckHasOrder;
use App\Http\Controllers\Api\DeleteUserApi;
use App\Http\Controllers\Api\GetBookingApi;
use App\Http\Controllers\Api\GetDashboardImagesApi;
use App\Http\Controllers\Api\GetDestinationsApi;
use App\Http\Controllers\Api\GetMyOrdersApi;
use App\Http\Controllers\Api\GetOrdersApi;
use App\Http\Controllers\Api\GetUserWalletsApi;
use App\Http\Controllers\Api\LoginUserApi;
use App\Http\Controllers\Api\LogoutUserApi;
use App\Http\Controllers\Api\OrderRideApi;
use App\Http\Controllers\Api\ProfileUserApi;
use App\Http\Controllers\Api\RegisterUserApi;
use App\Http\Controllers\Api\TacApiController;
use App\Http\Controllers\Api\UpdateUserApiController;
use App\Http\Controllers\Api\UpdateUserBiometricApi;
use App\Http\Controllers\Api\UpdateUserProfileApi;
use App\Http\Controllers\Api\UpdateUserWalletsApi;
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
    Route::get('orders', [GetOrdersApi::class, 'index'])->name('orders'); 
    Route::post('calculate-destination', [CalculateDataApi::class, 'calculate'])->name('calculate-destination');
    Route::get('dashboard-images', [GetDashboardImagesApi::class, 'index'])->name('dashboard-images');
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {

    // user controller / user profile / auth controller
    Route::post('profile', [ProfileUserApi::class, 'profile'])->name('profile');
    Route::post('update-user', [UpdateUserApiController::class, 'update'])->name('update-user');
    Route::post('update-profile', [UpdateUserProfileApi::class, 'update'])->name('update-profile');
    Route::post('update-biometric', [UpdateUserBiometricApi::class, 'update'])->name('update-biometric');
    Route::get('user-biometric', [BiometricUserApiController::class, 'biometric'])->name('user-biometric');
    Route::get('user-wallet', [GetUserWalletsApi::class, 'wallet'])->name('user-wallets');
    Route::post('update-wallet', [UpdateUserWalletsApi::class, 'update'])->name('update-wallet');

    Route::post('logout', [LogoutUserApi::class, 'logout'])->name('logout');
    Route::post('delete-user', [DeleteUserApi::class, 'delete'])->name('delete-user');
});

// student / staff / drivers
Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
   
   // destination / booking controller
   Route::post('order-ride', [OrderRideApi::class, 'order'])->name('order-ride');
   Route::post('accept-order', [AcceptOrderApi::class, 'accept'])->name('accept-order');
   
   Route::get('check-has-order', [CheckHasOrder::class, 'index'])->name('check-has-order'); // check if user has an order
   Route::post('cancel-order', [AcceptOrderApi::class, 'cancel'])->name('cancel-order');

   Route::get('my-current-order', [GetMyOrdersApi::class, 'index'])->name('my-orders'); // orders dedicated to the user

   Route::get('get-bookings', [GetBookingApi::class, 'index'])->name('my-bookings');

});