<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Authentication\CheckPasswordCode;
use App\Http\Controllers\Api\Authentication\ResetPasswordController;
use App\Http\Controllers\Api\Authentication\AuthenticationController;
use App\Http\Controllers\Api\Authentication\ForgotPasswordController;
use App\Http\Controllers\Api\Authentication\VerifyPhoneNumberController;


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

Route::get('products/', [ProductController::class, 'showAllProduct']);
Route::get('products/search', [ProductController::class, 'searchByName']);
Route::get('products/{category}', [ProductController::class, 'showProductByCategory']);

Route::get('categories', [CategoryController::class, 'showAllCateogry']);
Route::get('categories/{mainCategoryId}/subcategory', [CategoryController::class, 'subCategories']);
Route::get('categories/{subCateoryId}/subsubcategory', [CategoryController::class, 'subSubCategory']);

Route::post('auth/register', [AuthenticationController::class, 'register']);
Route::post('auth/login', [AuthenticationController::class, 'login']);
Route::post('auth/logout', [AuthenticationController::class, 'logout']);
Route::post('auth/changpassword', [AuthenticationController::class, 'changePassword'])->middleware('auth:sanctum');
Route::post('user/verfiy-phone-number', [VerifyPhoneNumberController::class, 'verify']);
Route::post('user/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('user/reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::post('user/check-code', [CheckPasswordCode::class, 'checkCode']);
