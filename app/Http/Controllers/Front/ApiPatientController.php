<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Doctors\IDoctorRepository;
use App\Repositories\Patients\IPatientRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Clinics\IClinicRepository;

class ApiPatientController extends Controller
{
    use ResponseTrait;
    public IClinicRepository $ClinicRepository;
    private IDoctorRepository $DoctorRepository;


    public function __construct(IClinicRepository $clinic,IDoctorRepository $DoctorRepository,IPatientRepository $patientRepository)
    {
        $this->ClinicRepository = $clinic;
        $this->DoctorRepository = $DoctorRepository;
        $this->PatientRepository = $patientRepository;

    }

    public function departments():JsonResponse{

        $departments = $this->ClinicRepository->index();
        if (!$departments){
            return $this->returnSuccess("There are no departments..");
        }else
        return $this->returnData("departments",$departments);

    }

    public function cities():JsonResponse{

        $cities = $this->PatientRepository->cities();
        if (!$cities){
            return $this->returnError("E300","There are no cities..");
        }else
            return $this->returnData("cities",$cities);
    }

    public function areas(Request $request):JsonResponse{
        $citie = $request->citie;
        $areas = $this->PatientRepository->areas($citie);
        if ($areas->count()==0){
            return $this->returnError("E301","There are no areas..");
        }else{
            return $this->returnData("areas",$areas);
        }
    }

    public function famous_doctors():JsonResponse{

        $famous_doctors = $this->DoctorRepository->getFamousDoctors();
        if ($famous_doctors->count()==0){
            return $this->returnSuccess("D01","There are no Famous Doctors..");
        }else
            return $this->returnData("famous doctors",$famous_doctors,"","D00");

    }


}
