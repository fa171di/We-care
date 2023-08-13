<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\back\cln_x_visits;
use App\Models\back\gnr_m_patients;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiVisitsController extends Controller
{
    use ResponseTrait;


    public function pat_visits():JsonResponse{
        $user = auth()->user();
        $userID = $user->id;
        $patient = gnr_m_patients::where('user_id',$userID)->first();
        if (!$patient){
            return $this->returnError("D01","there are no visits");
        }else{
            $visits = cln_x_visits::with('gnr_m_clinics')->where('patient','=',$patient->id)->get();
            if ($visits->count() == 0){
                return $this->returnError("D01","there are no visits");
            }else{
                foreach ($visits as $visit){
                    $newdate = Carbon::parse($visit->d_start)->format('Y-m-d الساعة: h:i A');
                    $visit->d_start = $newdate;
                }
                return $this->returnData("visits",$visits,"hi");
            }
        }
    }

//    public function fucking_database(){
//        $visits = cln_x_visits::all();
//        if (!$visits){
//            return"fuck off";
//        }else{
//            foreach ($visits as $visit){
//                $newdate = Carbon::parse($visit->d_start)->format('Y-m-d الساعة: h:i A');
//                $visit->d_start = $newdate;
//                $visit->save();
//            }
//            return "DataBase Fucked Successfully...";
//        }
//    }
}
