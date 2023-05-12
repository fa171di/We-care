<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Back\Cln_m_servicesController;
use App\Http\Controllers\Back\Cln_x_visitsController;
use App\Http\Controllers\Back\DoctorsController;
use App\Http\Controllers\Back\Gnr_m_clinicsController;
use App\Http\Controllers\Back\Gnr_m_patientsController;
use App\Http\Controllers\Back\Medical_fileController;
use App\Http\Controllers\Back\RoleController;
use App\Http\Controllers\Back\UserController;
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
    Route::resource('services', Cln_m_servicesController::class);

    //zRoute::get('/user/{id}', [UserController::class, 'show']);
    Route::get('/MedicalFile/create/{visit}/{clinic}', [Medical_fileController::class])->name("MedicalFile.create");;
    Route::resource('MedicalFile', Medical_fileController::class );

    Route::get('/{page}', [AdminController::class, 'index']);
});

require __DIR__.'/auth.php';
