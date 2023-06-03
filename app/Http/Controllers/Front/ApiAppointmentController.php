<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\back\Appointment;
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

    public function appointment_update(Request $request):JsonResponse
    {
        $user = auth()->user();
        $role = $user->roles_name;
        $userId = $user->id;
        if ($role == 'Patient'){
            $validator = Validator::make($request->all(),[
                'appointment_with' => 'required',
                'appointment_date' => 'required',
                'available_slot' => 'required',
                'appointment' => 'required',
            ]);
        }elseif ($role == 'Doctor'){
            $validator = Validator::make($request->all(),[
                'appointment_for' => 'required',
                'appointment_date' => 'required',
                'available_slot' => 'required',
                'appointment' => 'required',
            ]);
        }
        if($validator->fails()){
            return $this->returnError("V00",$validator->errors());
        }
        $appointment = Appointment::find($request->appointment);
        if (!$appointment){
            return $this->returnError("D01","Appointment not exist..");
        }
        $input = $request->all();
        if ($role == 'Patient'){
            $input['appointment_for'] = $userId;
        }elseif ($role == 'Doctor'){
            $input['appointment_with'] = $userId;
        }
        try {
            $this->AppointmentRepository->update($input,$appointment);
            return $this->returnSuccess("D00","Appointment Updated successfully");
        } catch (Exception $e) {
            return $this->returnError("D01",$e->getMessage());
        }
    }

    public function pat_appoints():JsonResponse{
        $appointments = $this->AppointmentRepository->pat_appoints();
        if (!$appointments){
            return $this->returnError("D01","There are no appointments..");
        }else{
            return $this->returnData("upcoming_Appointment",$appointments,"","D00");
        }
    }

    public function doc_appoints():JsonResponse{
        $appointments = $this->AppointmentRepository->doc_appoints();
        if (!$appointments){
            return $this->returnError("D01","There are no appointments..");
        }else{
            return $this->returnData("Appointments",$appointments,"","D00");
        }
    }

    public function doc_today_appoints():JsonResponse{
        $appointments = $this->AppointmentRepository->doc_today_appoints();
        if (!$appointments){
            return $this->returnError("D01","There are no appointments..");
        }else{
            return $this->returnData("Appointments",$appointments,"","D00");
        }
    }

    public function pat_canceled_appoints():JsonResponse{
        $appointments = $this->AppointmentRepository->pat_canceled_appoints();
        if (!$appointments){
            return $this->returnError("D01","There are no appointments..");
        }else{
            return $this->returnData("Appointments",$appointments,"","D00");
        }
    }

    public function cancel_appoint(Request $request):JsonResponse{
        $validator = Validator::make($request->all(),[
            'appointment' => 'required',
        ]);
        if($validator->fails()){
            return $this->returnError("V00",$validator->errors());
        }
        $appointment = Appointment::find($request->appointment);
        if (!$appointment){
            return $this->returnError("D01","Appointment Dos not Exist. . ");
        }else {
            $appoint = $appointment->id;
            $success = $this->AppointmentRepository->cancel_appoint($appoint);
            if (!$success){
                return $this->returnError("D01","something went wrong.. pleas try again");
            }
            return $this->returnSuccess("D00","appointment canceled successfully..");
        }
    }

    public function appointment_delete(Request $request):JsonResponse{
        $appointment = Appointment::find($request->appointment);
        if (!$appointment){
            return $this->returnError("D01","appointment not exist..");
        }
       $appoint = $this->AppointmentRepository->destroy($appointment);
        return $this->returnSuccess("D00","appointment deleted successfully..");
    }


}
