<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\back\gnr_m_clinics;
use App\Repositories\Clinics\IClinicRepository;
use App\Repositories\Doctors\IDoctorRepository;
use App\Repositories\Patients\IPatientRepository;
use App\Repositories\Reviews\IReviewRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiDoctorController extends Controller
{
    use ResponseTrait;

    public IClinicRepository $ClinicRepository;
    private IDoctorRepository $DoctorRepository;
    public IPatientRepository $patientRepository;
    public IReviewRepository $ReviewRepository;

    public function __construct(IClinicRepository $clinic, IReviewRepository $ReviewRepository, IDoctorRepository $DoctorRepository, IPatientRepository $patientRepository)
    {
        $this->ClinicRepository = $clinic;
        $this->DoctorRepository = $DoctorRepository;
        $this->PatientRepository = $patientRepository;
        $this->ReviewRepository = $ReviewRepository;

    }

    public function dep_doctor(Request $request): JsonResponse
    {
        $clinic = $request->clinic;
        $doctors = $this->DoctorRepository->show($clinic);
        if (!$doctors) {
            return $this->returnError("D01", "there are no doctors");
        } else {
            return $this->returnData("doctors", $doctors, "", "D00");
        }

    }

    public function review(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'doctor' => 'required',
            'rating' => 'required',
            'typeUser' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnError("V00", $validator->errors());
        }
        try {

            $data = $this->ReviewRepository->store($request);
            if ($data['result'] == "تم الحفظ بنجاح"){
                return $this->returnSuccess("D00", "Review successfully..");
            }
            elseif ($data['result'] == "يوجد خطأ ما"){
                return $this->returnError("D01", "Something went Wrong... Pleas Try Again");
            }
        } catch (\Exception $ex) {
            DB::rollback();
            return $this->returnError("V00", $ex);
        }
    }

    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'val' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnError("V00", $validator->errors());
        }
        $key = $request->val;
        $doctors = $this->DoctorRepository->search($key);
        if ($doctors->count() == 0) {
            return $this->returnData("doctors", null, "there are no results", "D01");
        } else {
            return $this->returnData("doctors", $doctors, "", "D00");
        }
    }

}
