<?php

namespace App\Providers;

use App\Repositories\Appointments\AppointmentRepository;
use App\Repositories\Appointments\IAppointmentRepository;
use App\Repositories\Clinics\ClinicsRepository;
use App\Repositories\Clinics\IClinicRepository;
use App\Repositories\Doctors\DoctorRepository;
use App\Repositories\Doctors\IDoctorRepository;
use App\Repositories\Patients\IPatientRepository;
use App\Repositories\Patients\PatientRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IDoctorRepository::class,DoctorRepository::class);
        $this->app->bind(IPatientRepository::class,PatientRepository::class);
        $this->app->bind(IClinicRepository::class,ClinicsRepository::class);
        $this->app->bind(IAppointmentRepository::class,AppointmentRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
