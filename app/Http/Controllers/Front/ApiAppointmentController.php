<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\back\doctors;
use App\Repositories\Appointments\IAppointmentRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

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

    public function appointment_store(Request $request):JsonResponse
    {
        $user = auth()->user();
        $role = $user->roles_name;
        $userId = $user->id;
        if ($role == 'Patient'){
            $validator = Validator::make($request->all(),[
                'appointment_with' => 'required',
                'appointment_date' => 'required',
                'available_slot' => 'required',
            ]);
        }elseif ($role == 'Doctor'){
            $validator = Validator::make($request->all(),[
                'appointment_for' => 'required',
                'appointment_date' => 'required',
                'available_slot' => 'required',
            ]);
        }
        if($validator->fails()){
            return $this->returnError("V00",$validator->errors());
        }
        $input = $request->all();
        if ($role == 'Patient'){
            $input['appointment_for'] = $userId;
        }elseif ($role == 'Doctor'){
            $input['appointment_with'] = $userId;
        }
        try {
            $appointment = $this->AppointmentRepository->store($input);
            return $this->returnSuccess("D00","Appointment successfully");
        } catch (Exception $e) {
            return $this->returnError("D01",$e->getMessage());
        }
    }

    public function pat_appoints():JsonResponse{
        $appointments = $this->AppointmentRepository->pat_appoints();
        if (!$appointments){
            return $this->returnData("upcoming_Appointment",$appointments,"","D00");
        }else{
            return $this->returnError("D01","There are no appointments..");
        }
    }


}
