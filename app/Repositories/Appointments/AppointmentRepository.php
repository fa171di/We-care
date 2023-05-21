<?php

namespace App\Repositories\Appointments;

use App\Models\back\Appointment;
use App\Models\back\doctors;
use App\Models\User;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentRepository implements IAppointmentRepository
{
    use UploadFileTrait;
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

    public function update(Request $request, Appointment $appointment)
    {
        $date = $request->appointment_date;
        $newDate = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
        try {
            DB::transaction(function () use ($request,$appointment,$newDate) {
                $appoint = Appointment::findOrFail($appointment)->get();
                $appoint->appointment_for = $request->appointment_for;
                $appoint->appointment_with = $request->appointment_with;
                $appoint->from_time =$request->from_time;
                $appoint->to_time=$request->to_time;
                $appoint->slot_time=$request->slot_time;
                $appoint->user_id=$request->user_id;
                $doctor->phone_number=$request->phone_number;
                $doctor->subgrp= $request->subgrp;
                $doctor->sex=$request->sex;
                $doctor->specialization_ar=$request->specialization_ar;
                $doctor->save();
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }

    }

    public function store(Request $request)
    {
        $date = $request->appointment_date;
        $newDate = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
        try {
            DB::transaction(function () use ($request,$newDate) {
                Appointment::create([
                    'appointment_for' => $request->appointment_for,
                    'appointment_with' => $request->appointment_with,
                    'appointment_date' => $newDate,
                    'available_time' => $request->available_time,
                    'available_slot' => $request->available_slot,
                ]);
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }
    }

    public function destroy($appointment)
    {
        try {
            DB::transaction(function () use ($appointment) {
                $appoint = Appointment::findOrFail($appointment)->get();
                    $appoint->is_deleted=1;
                    $appoint->save();
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }
    }


}
