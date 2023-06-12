<?php

namespace App\Repositories\Appointments;

use App\Models\back\Appointment;
use App\Models\back\DoctorAvailableDay;
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

    public function index(){
        $user = auth()->user();
        $role = $user->roles_name;
        $query = Appointment::query()->with('doctor','timeSlot')
            ->orderBy('id', 'DESC');
        $appointments = null;
        if ($role == 'Doctor'){
            $appointments = $query->where('appointment_with',$user->id)
                ->where('is_deleted','=',0)->get();
        }elseif ($role == 'Reception'){
            $appointments = $query->where('is_deleted',0)->get();
        }
        return $appointments;
    }

    public function patient_appoi($id){
        return Appointment::with('doctor','timeSlot')
            ->where('appointment_for',$id)
            ->where('is_deleted',0)
            ->orderBy('id', 'DESC')->get();
    }

    public function pat_appoints()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $today = Carbon::today()->format('Y-m-d');
        return Appointment::with('doctor', 'timeSlot')
            ->where('appointment_for', $user_id)
            ->whereDate('appointment_date', '>', $today)
            ->where('is_deleted', 0)
            ->orderBy('id', 'DESC')->get();
    }

    public function doc_appoints()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $today = Carbon::today()->format('Y/m/d');
        $doctor = doctors::where('user_id', $user_id)->first();
        $doc_id = $doctor->id;
        return Appointment::with('patient', 'timeSlot')
            ->where('appointment_with', $doc_id)
            ->whereDate('appointment_date', '>', $today)
            ->where('is_deleted', 0)
            ->orderBy('id', 'DESC')->get();
    }

    public function doc_today_appoints()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $today = Carbon::today()->format('Y/m/d');
        $doctor = doctors::where('user_id', $user_id)->first();
        $doc_id = $doctor->id;
        return Appointment::with('patient', 'timeSlot')
            ->where('appointment_with', $doc_id)
            ->whereDate('appointment_date', '=', $today)
            ->where('is_deleted', 0)
            ->orderBy('id', 'DESC')->get();
    }

    public function pat_canceled_appoints()
    {
        $user = auth()->user();
        $user_id = $user->id;
        return Appointment::with('doctor', 'timeSlot')
            ->where('appointment_for', $user_id)
            ->where('status', 2)
            ->where('is_deleted',0)
            ->orderBy('id', 'DESC')->get();
    }

    public function pat_previos_appoints()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $today = Carbon::today()->format('Y/m/d');
        return Appointment::with('doctor', 'timeSlot')
            ->where('appointment_for', $user_id)
            ->whereDate('appointment_date', '<', $today)
            ->where('is_deleted',0)
            ->orderBy('id', 'DESC')->get();
    }

    public function show($appointment)
    {
        return $this->Appointment::with('patient', 'doctor');
    }

    public function doctor_available_days($doc)
    {
        $doctor = doctors::with('available_days')->find($doc);
        $days = DoctorAvailableDay::where('doctor_id', $doctor->id)->first();
        return $days;
    }

    public function slots($doc, $dates)
    {

        $appointment_slot = DoctorAvailableSlot::with(['appointment' => function ($re) use ($dates) {
            $re->where('appointment_date', $dates);
        }])->where('doctor_id', $doc)->get();
        $slots[] = null;
        $i = 0;
        foreach ($appointment_slot as $slot) {
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
            DB::transaction(function () use ($input, $appointment, $newDate) {
                $appoint = Appointment::findOrFail($appointment)->get();
                $appoint->appointment_for = $input['appointment_for'];
                $appoint->appointment_with = $input['appointment_with'];
                $appoint->appointment_date = $newDate;
                $appoint->slot_time = $input['slot_time'];
                $appoint->save();
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }

    }

    public function store($input)
    {
        $user = auth()->user();
        try {
            $date = $input['appointment_date'];
            $newDate = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
            if ($user->roles_name == 'Patient') {
                $id_doc = $input['appointment_with'];
                $doctor = doctors::find($id_doc);
                $apointment = Appointment::create([
                    'appointment_for' => $user->id,
                    'appointment_with' => $doctor->user_id,
                    'appointment_date' => $newDate,
                    'available_slot' => $input['available_slot'],
                ]);
            } elseif ($user->roles_name == 'Doctor') {
                $apointment = Appointment::create([
                    'appointment_for' => $input['appointment_for'],
                    'appointment_with' => $user->id,
                    'appointment_date' => $newDate,
                    'available_slot' => $input['available_slot'],
                ]);
            } elseif ($user->roles_name == 'Reception') {
                $id_doc = $input['appointment_with'];
                $doctor = doctors::find($id_doc);
                $apointment = Appointment::create([
                    'appointment_for' => $input['appointment_for'],
                    'appointment_with' => $doctor->user_id,
                    'appointment_date' => $newDate,
                    'available_slot' => $input['available_slot'],
                ]);
            }
            return $apointment;
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function destroy($appointment)
    {
        $appoint = Appointment::find($appointment);
        $appoint->is_deleted = 1;
        $appoint->save();
    }

    public function cancel_appoint($appointment)
    {
        $appoint = Appointment::find($appointment);
        $appoint->status = 2;
        $appoint->save();
        return $appoint;
    }
}
