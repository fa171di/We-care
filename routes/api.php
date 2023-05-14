<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

##################################### Auth Apis #########################################
Route::post('register', [ApiAuthController::class, 'register']);
Route::post('Api_login', [ApiAuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('email/verify', [ApiAuthController::class, 'verify']);
    Route::get('email/resend', [ApiAuthController::class, 'resend']);
    Route::post('logout', [ApiAuthController::class, 'logout']);
    Route::get('home',[ApiAuthController::class,'home']);
});
#########################################################################################







