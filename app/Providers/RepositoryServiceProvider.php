<?php

namespace App\Providers;

use App\Repositories\Ads\AdsRepository;
use App\Repositories\Ads\IAdsRepository;
use App\Repositories\Appointments\AppointmentRepository;
use App\Repositories\Appointments\IAppointmentRepository;
use App\Repositories\Clinics\ClinicsRepository;
use App\Repositories\Clinics\IClinicRepository;
use App\Repositories\Doctors\DoctorRepository;
use App\Repositories\Doctors\IDoctorRepository;
use App\Repositories\Medical_file\IMedicalFileRepository;
use App\Repositories\Medical_file\MedicalFileRepository;
use App\Repositories\Patients\IPatientRepository;
use App\Repositories\Patients\PatientRepository;
use App\Repositories\Questions\IQuestionsRepository;
use App\Repositories\Questions\QuestionsRepository;
use App\Repositories\Reviews\IReviewRepository;
use App\Repositories\Reviews\ReviewRepository;
use App\Repositories\Serveices\IServiceRepository;
use App\Repositories\Serveices\ServiceRepository;
use App\Repositories\Wallet\IWalletRepository;
use App\Repositories\Wallet\WalletRepository;
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
        $this->app->bind(IServiceRepository::class,ServiceRepository::class);
        $this->app->bind(IMedicalFileRepository::class,MedicalFileRepository::class);
        $this->app->bind(IWalletRepository::class,WalletRepository::class);
        $this->app->bind(IAppointmentRepository::class,AppointmentRepository::class);
        $this->app->bind(IAdsRepository::class,AdsRepository::class);
        $this->app->bind(IReviewRepository::class,ReviewRepository::class);
        $this->app->bind(IQuestionsRepository::class,QuestionsRepository::class);



    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
