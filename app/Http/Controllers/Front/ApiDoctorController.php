<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\back\gnr_m_clinics;
use App\Repositories\Clinics\IClinicRepository;
use App\Repositories\Doctors\IDoctorRepository;
use App\Repositories\Patients\IPatientRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ApiDoctorController extends Controller
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

    public function dep_doctor(Request $request):JsonResponse{
        $clinic = $request->clinic;
        $doctors = $this->DoctorRepository->show($clinic);
        if (!$doctors){
            return $this->returnError("D01","there are no doctors");
        }else{
            return $this->returnData("doctors",$doctors,"","D00");
        }

    }

    public function search(Request $request):JsonResponse{
        $validator = Validator::make($request->all(), [
            'val' => 'required',
        ]);

        if($validator->fails()){
            return $this->returnError("V00",$validator->errors());
        }
        $key = $request->val;
        $doctors = $this->DoctorRepository->search($key);
        if (!$doctors){
            return $this->returnError("D01","there are no results");
        }
        else{
            return $this->returnData("doctors",$doctors,"","D00");
        }
    }


}
