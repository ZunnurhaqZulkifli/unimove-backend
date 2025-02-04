<?php

use App\Http\Controllers\Api\BiometricUserApiController;
use App\Http\Controllers\Api\CalculateDataApi;
use App\Http\Controllers\Api\DeleteUserApi;
use App\Http\Controllers\Api\GetDashboardImagesApi;
use App\Http\Controllers\Api\ChangePasscodeController;
use App\Http\Controllers\Api\DestinationsApi;
use App\Http\Controllers\Api\UserWalletsApi;
use App\Http\Controllers\Api\LoginUserApi;
use App\Http\Controllers\Api\LogoutUserApi;
use App\Http\Controllers\Api\ProfileUserApi;
use App\Http\Controllers\Api\RegisterUserApi;
use App\Http\Controllers\Api\TacApiController;
use App\Http\Controllers\Api\UpdateUserApiController;
use App\Http\Controllers\Api\UpdateUserBiometricApi;
use App\Http\Controllers\Api\UpdateUserProfileApi;
use App\Http\Controllers\Api\UpdateUserWalletsApi;
use App\Http\Controllers\Api\CustomerBookingController;
use App\Http\Controllers\Api\CustomerOrderController;
use App\Http\Controllers\Api\DriverOrderController;
use App\Http\Controllers\Api\DriverBookingController;
use App\Http\Controllers\Api\UserRidesHistoryApi;
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
    Route::get('destinations', [DestinationsApi::class, 'index'])->name('destinations');
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
    Route::get('user-wallet', [UserWalletsApi::class, 'wallet'])->name('user-wallets');
    Route::post('update-wallet', [UpdateUserWalletsApi::class, 'update'])->name('update-wallet');
    Route::get('ride-histories', [UserRidesHistoryApi::class, 'rides'])->name('ride-history');

    Route::post('logout', [LogoutUserApi::class, 'logout'])->name('logout');
    Route::post('delete-user', [DeleteUserApi::class, 'delete'])->name('delete-user');
    Route::post('change-passcode', [ChangePasscodeController::class, 'index'])->name('change-passcode');
});

// student / staff / drivers
Route::prefix('v1/customer')->middleware(['auth:sanctum'])->group(function () {
   
   // destination / booking controller
   Route::get('order-check', [CustomerOrderController::class, 'check'])->name('customer-check-has-order');  // check if user has an order
   Route::post('order-ride', [CustomerOrderController::class, 'order'])->name('customer-order-ride');
   Route::post('cancel-order', [CustomerOrderController::class, 'cancelOrder'])->name('customer-cancel-order');
   Route::get('get-active-order', [CustomerOrderController::class, 'getOrder'])->name('customer-get-order');  // orders dedicated to the user
   
   Route::get('booking-check', [CustomerBookingController::class, 'check'])->name('customer-check-has-booking');
   Route::get('get-active-booking', [CustomerBookingController::class, 'getBooking'])->name('customer-get-booking');
   Route::get('on-going-ride', [CustomerBookingController::class, 'onGoingRide'])->name('on-going-ride');
   Route::get('complete-ride', [CustomerBookingController::class, 'completeRide'])->name('complete-ride');
});

Route::prefix('v1/driver')->middleware(['auth:sanctum'])->group(function () {
   
    // destination / booking controller
    // Route::get('order-check', [DriverOrderController::class, 'check'])->name('check-has-order');  // check if user has an order
    Route::get('orders', [DriverOrderController::class, 'index'])->name('driver-all-orders'); 
    Route::get('order-check', [DriverOrderController::class, 'check'])->name('driver-check-has-order');
    Route::post('accept-order', [DriverOrderController::class, 'accept'])->name('driver-accept-order');
    Route::post('cancel-order', [DriverOrderController::class, 'cancelOrder'])->name('driver-cancel-order');
    Route::get('get-active-order', [DriverOrderController::class, 'getOrder'])->name('driver-get-order');
    
    Route::get('booking-check', [DriverBookingController::class, 'check'])->name('driver-check-has-booking');
    Route::get('get-active-booking', [DriverBookingController::class, 'getBooking'])->name('driver-get-booking');
    Route::get('on-going-ride', [DriverBookingController::class, 'onGoingRide'])->name('driver-on-going-ride');
   Route::get('complete-ride', [DriverBookingController::class, 'completeRide'])->name('driver-complete-ride');
 });