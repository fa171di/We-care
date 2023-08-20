<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\back\cln_m_medical_his_cats;
use App\Models\back\cln_x_visits;
use App\Models\back\gnr_m_patients;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiMedical_fileController extends Controller
{
    use ResponseTrait;


    public function medical_info(Request $request):JsonResponse{
        $validator = Validator::make($request->all(), [
            'visit' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnError("V00", $validator->errors());
        }
        $dia = "" ;
        $dia10 = "";
        $cln_m_medical_his_cats = cln_m_medical_his_cats::all();
        $visit = cln_x_visits::find($request->visit);
        $patient = gnr_m_patients::find($visit->patient);
        $visitID = $visit->id;
        $patientId  = $visit->patient;
        $clinic = $visit->clinic;
        $patients_medical_info = $patient->gnr_m_patients_medical_info;
        $sensitivity =  $patient->cln_m_medical_his->where('cat',1);
        $surgery =  $patient->cln_m_medical_his->where('cat',2);
        $chronic =  $patient->cln_m_medical_his->where('cat',3);
        $medicine =  $patient->cln_m_medical_his->where('cat',4);
        $services = $visit->cln_m_services;
        $com = $visit->cln_x_prev_com;
        $str = $visit->cln_x_prev_str;
        $cln = $visit->cln_x_prev_cln;
        $note = $visit->cln_x_prev_not;
        if ($visit->cln_m_icd10->isNotEmpty()) {
            $dia10 = $visit->cln_m_icd10;
        }
        if ($visit->cln_x_prev_dia->isNotEmpty()) {
            $dia = $visit->cln_x_prev_dia;
        }
        return response()->json([
            'success' => true,
            'error' => "D00",
            'services'=>$services,
            'patients_medical_info'=>$patients_medical_info,
            'visitID'=>$visitID,
            'clinic'=>$clinic,
            'dia10'=>$dia10,
            'sensitivity'=>$sensitivity,
            'surgery'=>$surgery,
            'chronic'=>$chronic,
            'medicine'=>$medicine,
            'patientId'=>$patientId,
            'cln_m_medical_his_cats'=>$cln_m_medical_his_cats,
            'note'=>$note,
            'com'=>$com,
            'str'=>$str,
            'cln'=>$cln,
            'dia'=>$dia,
        ]);
    }
}
