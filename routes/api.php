<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Front\ApiAppointmentController;
use App\Http\Controllers\Front\ApiPatientController;
use App\Http\Controllers\Front\ApiDoctorController;
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
    Route::get('profile',[ApiAuthController::class,'profile']);
});
#########################################################################################
Route::middleware('auth:api')->group(function (){
    Route::get('departments',[ApiPatientController::class,'departments']);
    Route::get('famous_doctors',[ApiPatientController::class,'famous_doctors']);
    Route::post('doctors_by_department',[ApiDoctorController::class,'dep_doctor']);
    Route::post('search',[ApiDoctorController::class,'search']);
    ################################# Appointment Apis ########################################
    Route::post('doctor_available_days',[ApiAppointmentController::class,'doctor_available_days']);
    Route::post('slots',[ApiAppointmentController::class,'slots_by_day']);
    Route::post('appointment-store',[ApiAppointmentController::class,'appointment_store']);
    Route::post('appointment-update',[ApiAppointmentController::class,'appointment_update']);
    Route::get('patient-appointments',[ApiAppointmentController::class,'pat_appoints']);
    Route::get('doctor-appointments',[ApiAppointmentController::class,'doc_appoints']);
    Route::get('patient-canceled-appointments',[ApiAppointmentController::class,'pat_canceled_appoints']);
    Route::get('doctor-today-appointments',[ApiAppointmentController::class,'doc_today_appoints']);
    Route::post('cancel-appointment',[ApiAppointmentController::class,'cancel_appoint']);
    Route::post('appointment-delete',[ApiAppointmentController::class,'appointment_delete']);
    #############################################################################################
});






