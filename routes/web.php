<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Back\AdsController;
use App\Http\Controllers\Back\AppointmentController;
use App\Http\Controllers\Back\Cln_m_medical_hisController;
use App\Http\Controllers\Back\Cln_m_servicesController;
use App\Http\Controllers\Back\Cln_x_prev_clnController;
use App\Http\Controllers\Back\Cln_x_prev_noteController;
use App\Http\Controllers\Back\Cln_x_prev_comController;
use App\Http\Controllers\Back\Cln_x_prev_diaController;
use App\Http\Controllers\Back\Cln_x_prev_icd10Controller;
use App\Http\Controllers\Back\Cln_x_visitsController;
use App\Http\Controllers\Back\DoctorsController;
use App\Http\Controllers\Back\Gnr_m_clinicsController;
use App\Http\Controllers\Back\Gnr_m_patientsController;
use App\Http\Controllers\Back\Cln_x_prev_strController;
use App\Http\Controllers\Back\Gnr_m_patientsInfoController;
use App\Http\Controllers\Back\Medical_fileController;
use App\Http\Controllers\Back\QuestionsController;
use App\Http\Controllers\Back\ReportsController;
use App\Http\Controllers\Back\ReviewsController;
use App\Http\Controllers\Back\RoleController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\WalletController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(callback: function () {


    Route::get('/profile1', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile1', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile1', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::resource('departments', Gnr_m_clinicsController::class);

    //Route::get('/doctors/{doctors}/edit/section',  [DoctorsController::class, 'edit'])->name("doctors.edit");
    Route::resource('doctors', DoctorsController::class);
    Route::resource('patients', Gnr_m_patientsController::class);
    Route::resource('visits', Cln_x_visitsController::class);
    // Route::get('visits/MyVisits',  [Cln_x_visitsController::class, 'getVisitForDoctor']);

    // Route::get('/services/{id}/{clinic}/edit', [Cln_m_servicesController::class])->name("services.edit");
    Route::resource('services', Cln_m_servicesController::class);
    Route::resource('medical', Cln_m_medical_hisController::class);
    Route::resource('com', Cln_x_prev_comController::class);
    Route::resource('str', Cln_x_prev_strController::class);
    Route::resource('cln', Cln_x_prev_clnController::class);
    Route::resource('dia', Cln_x_prev_icd10Controller::class);
    Route::resource('note', Cln_x_prev_noteController::class);
    Route::resource('patients_info', Gnr_m_patientsInfoController::class);
    Route::resource('report', ReportsController::class);
    Route::resource('wallet', WalletController::class);
    Route::resource('ads', AdsController::class);
    Route::resource('review', ReviewsController::class);
    Route::resource('questions', QuestionsController::class);
    Route::get('/questions/{section}/answer', [QuestionsController::class,'answerTheQ'])->name("questions.answer");
    Route::get('/questions/user/{user}', [QuestionsController::class,'userQuestions'])->name("questions.user");

###################################### Appointment Routes ######################################################
    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::post('appointment-status/{id}', [AppointmentController::class, 'appointment_status']);
    Route::get('getMonthlyAppointments', [AppointmentController::class, 'getMonthlyAppointments']);
    Route::post('/doctor-by-day-time', [AppointmentController::class, 'doctor_by_day_time'])->name('doctor_by_day_time');
    Route::post('/appointment-time-by-appointment-slot', [AppointmentController::class, 'time_by_slot'])->name('timeBySlot');
    Route::get('appointment-create', [AppointmentController::class, 'appointment_create']);
    Route::post('appointment-store', [AppointmentController::class, 'store']);
    Route::get('/cal-appointment-show', [AppointmentController::class, 'cal_appointment_show']);
    Route::get('pending-appointment', [AppointmentController::class, 'pending_appointment']);
    Route::get('upcoming-appointment', [AppointmentController::class, 'upcoming_appointment']);
    Route::get('confirm-appointment/{id}', [AppointmentController::class, 'confirm']);
    Route::get('cancel-appointment/{id}', [AppointmentController::class, 'cancel']);
    Route::get('today-appointment', [AppointmentController::class, 'today_appointment']);
    Route::get('patient-appointments/{id}', [AppointmentController::class, 'patient_appointments']);
    Route::post('filter_App', [AppointmentController::class, 'filter']);
####################################################################################################################

    //zRoute::get('/user/{id}', [UserController::class, 'show']);
    //Route::get('/MedicalFile/create/{visit}/{clinic}/{patient}', [Medical_fileController::class])->name("MedicalFile.create");;
    Route::resource('MedicalFile', Medical_fileController::class);

    Route::get('/{page}', [AdminController::class, 'index']);

});

require __DIR__ . '/auth.php';
