<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Front\ApiAppointmentController;
use App\Http\Controllers\Front\ApiPatientController;
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
Route::get('cities',[ApiPatientController::class,'cities']);
Route::post('areas',[ApiPatientController::class,'areas']);
Route::middleware('auth:api')->group(function () {
    Route::post('email/verify', [ApiAuthController::class, 'verify']);
    Route::get('email/resend', [ApiAuthController::class, 'resend']);
    Route::post('logout', [ApiAuthController::class, 'logout']);
    Route::get('home',[ApiAuthController::class,'home']);
});
#########################################################################################
Route::middleware('auth:api')->group(function (){
    Route::get('departments',[ApiPatientController::class,'departments']);
    Route::get('famous_doctors',[ApiPatientController::class,'famous_doctors']);
    ################################# Appointment Apis ########################################
    Route::post('appointment-store',[ApiAppointmentController::class,'appointment_store']);
    Route::get('patient-appointments',[ApiAppointmentController::class,'pat_appoints']);
    Route::get('doctor-appointments',[ApiAppointmentController::class,'doc_appoints']);
    Route::get('patient-upcoming-appointments',[ApiAppointmentController::class,'pat_upcoming_appoints']);
    Route::get('doctor-upcoming-appointments',[ApiAppointmentController::class,'doc_upcoming_appoints']);
    Route::get('cancel-appointment/{id}',[ApiAppointmentController::class,'cancel_appoint']);
    Route::get('confirm-appointment/{id}',[ApiAppointmentController::class,'confirm_appoint']);
    Route::get('today-appointments',[ApiAppointmentController::class,'today_appoints']);
    #############################################################################################
});






