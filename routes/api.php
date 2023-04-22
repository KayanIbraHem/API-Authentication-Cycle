<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\VerifyPhoneNumberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('index', function () {
    return 'Success';
});

Route::post('auth/register', [AuthenticationController::class, 'register']);
Route::post('auth/login', [AuthenticationController::class, 'login']);
Route::post('auth/logout', [AuthenticationController::class, 'logout']);
Route::post('auth/changpassword', [AuthenticationController::class, 'changePassword'])->middleware('auth:sanctum');

Route::post('user/verfiy-phone-number', [VerifyPhoneNumberController::class, 'verify']);

Route::post('user/forgot-password',[ForgotPasswordController::class,'forgotPassword']);

Route::post('user/reset-password',[ResetPasswordController::class,'resetPassword']);
