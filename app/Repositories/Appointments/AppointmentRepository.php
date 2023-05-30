<?php

namespace App\Repositories\Appointments;

use App\Models\back\Appointment;
use App\Models\back\DoctorAvailableSlot;
use App\Models\back\doctors;
use App\Models\User;
use App\Traits\ResponseTrait;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentRepository implements IAppointmentRepository
{
    use UploadFileTrait;
    use ResponseTrait;
    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->Appointment = $appointment;
    }

    public function pat_appoints(){
        $user = auth()->user();
        $user_id = $user->id;
        $today = Carbon::today()->format('Y/m/d');
        return Appointment::with('doctor','timeSlot')
            ->where('appointment_for', $user_id)
            ->whereDate('appointment_date', '>=', $today)
            ->where('status', 0)->get();
    }

    public function doc_appoints(){
        $user = auth()->user();
        $user_id = $user->id;
        $today = Carbon::today()->format('Y/m/d');
        $doctor = doctors::where('user_id',$user_id)->first();
        $doc_id = $doctor->id;
        return Appointment::with('patient','timeSlot')
            ->where('appointment_with', $doc_id)
            ->whereDate('appointment_date', '>', $today)
            ->where('status', 0)
            ->orderBy('id', 'DESC')->get();
    }

    public function doc_today_appoints(){
        $user = auth()->user();
        $user_id = $user->id;
        $today = Carbon::today()->format('Y/m/d');
        $doctor = doctors::where('user_id',$user_id)->first();
        $doc_id = $doctor->id;
        return Appointment::with('patient','timeSlot')
            ->where('appointment_with', $doc_id)
            ->whereDate('appointment_date', '=', $today)
            ->where('status', 0)
            ->orderBy('id', 'DESC')->get();
    }

    public function pat_canceled_appoints(){
        $user = auth()->user();
        $user_id = $user->id;
        return Appointment::with('doctor','timeSlot')
            ->where('appointment_for', $user_id)
            ->where('status', 2)
            ->orderBy('id', 'DESC')->get();
    }

    public function show($appointment)
    {
        return $this->Appointment::with('patient','doctor');
    }

    public function doctor_available_days($doc){
        $doctor =doctors::with('available_days')->find($doc);
        return $doctor->available_days;
    }

    public function slots($doc,$dates){

        $appointment_slot = DoctorAvailableSlot::with(['appointment' => function ($re) use ($dates) {
            $re->where('appointment_date', $dates);
        }])->where('doctor_id', $doc)->get();
        $slots[]=null;
        $i=0;
        foreach ($appointment_slot as $slot){
            if ($slot->appointment->count() == 0) {
                $slots[$i] = $slot;
                $i++;
            }
        }
        return $slots;
    }

    public function update($input, Appointment $appointment)
    {
        $date = $input['appointment_date'];
        $newDate = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
        try {
            DB::transaction(function () use ($input,$appointment,$newDate) {
                $appoint = Appointment::findOrFail($appointment)->get();
                $appoint->appointment_for =$input['appointment_for'];
                $appoint->appointment_with =$input['appointment_with'];
                $appoint->appointment_date = $newDate;
                $appoint->slot_time=$input['slot_time'];
                $appoint->save();
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }

    }

    public function store($input)
    {
        $date = $input['appointment_date'];
        $newDate = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
        try {
            DB::transaction(function () use ($input,$newDate) {
                Appointment::create([
                    'appointment_for' =>$input['appointment_for'],
                    'appointment_with' => $input['appointment_with'],
                    'appointment_date' => $newDate,
                    'available_slot' => $input['available_slot'],
                ]);
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }
    }

    public function destroy($appointment)
    {
        $appoint = Appointment::find($appointment->id);
        $appoint->is_deleted=1;
        $appoint->save();
    }

    public function cancel_appoint($appointment)
    {
            $appoint = Appointment::find($appointment);
            $appoint->status=1;
            $appoint->save();
            return $appoint;
    }
}
