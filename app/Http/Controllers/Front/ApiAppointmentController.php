<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\back\doctors;
use App\Repositories\Appointments\IAppointmentRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiAppointmentController extends Controller
{
    use ResponseTrait;
    public $appointment;

    public function __construct(IAppointmentRepository $appointmentRepository)
    {
        $this->AppointmentRepository = $appointmentRepository;
    }

    public function doctor_available_days(Request $request):JsonResponse{
        $doc=$request->doctor;
        $doctor = doctors::find($doc);
        if (!$doctor){
            return $this->returnError("D00","Doctor not found");
        }else{
            $available_days = $this->AppointmentRepository->doctor_available_days($doc);
            return $this->returnData("available_days",$available_days);
        }
    }

    public function slots_by_day(Request $request):JsonResponse{

        $doc  = $request->doctor;
        $doctor = doctors::find($doc);
        if (!$doctor){
            return $this->returnError("D00","Doctor not found");
        }else{
            $date  = $request->date;
            $dates = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
            $slots = $this->AppointmentRepository->slots($doc,$dates);
            if (!$slots){
                return $this->returnError("D00","Slots not found");
            }else{
                return $this->returnData("slots",$slots);
            }
        }
    }

}
