<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Doctors\IDoctorRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Clinics\IClinicRepository;

class ApiPatientController extends Controller
{
    use ResponseTrait;
    public IClinicRepository $ClinicRepository;
    private IDoctorRepository $DoctorRepository;


    public function __construct(IClinicRepository $clinic,IDoctorRepository $DoctorRepository)
    {
        $this->ClinicRepository = $clinic;
        $this->DoctorRepository = $DoctorRepository;
    }

    public function departments():JsonResponse{

        $departments = $this->ClinicRepository->index();
        if (!$departments){
            return $this->returnSuccess("There are no departments..");
        }else
        return $this->returnData("departments",$departments);

    }

    public function famous_doctors():JsonResponse{

        $famous_doctors = $this->DoctorRepository->getFamousDoctors();
        if ($famous_doctors->count()==0){
            return $this->returnSuccess("There are no Famous Doctors..");
        }else
            return $this->returnData("famous doctors",$famous_doctors);

    }

//    public function update(Request $request):JsonResponse{
//
//    }



}
