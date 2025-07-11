<?php

use App\Http\Controllers\OtpVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/otp/send', [OtpVerificationController::class, 'sendOtp']);
Route::post('/otp/verify', [OtpVerificationController::class, 'verifyOtp']);
