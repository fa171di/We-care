<?php

namespace App\Repositories\Doctors;

use App\Models\back\DoctorAvailableDay;
use App\Models\back\DoctorAvailableSlot;
use App\Models\back\doctors;
use App\Models\User;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorRepository implements IDoctorRepository
{
    use UploadFileTrait;
    public $doctor;
    public $availableDay;
    public $availableSlot;

    public function __construct(doctors $doctor,DoctorAvailableDay $availableDay,DoctorAvailableSlot $availableSlot)
    {
        $this->doctor = $doctor;
        $this->availableDay= $availableDay;
        $this->availableSlot= $availableSlot;
    }
    public function index()
    {

        return doctors::with('user','gnr_m_clinics')->get();
        //dd($doctor);
    }

    public function getFamousDoctors(){
        return doctors::with('user','gnr_m_clinics')
            ->where('famous' ,'=',0)->get();
    }


    public function show($department)
    {
        return doctors::with('user','gnr_m_clinics')->where('subgrp','=',$department)->get();
    }

    public function edit($doctor)
    {
        $doc = $this->doctor::with('user')->where('id','=',$doctor)->get();
        $user =  User::all();
       return [$doc,$user];
    }

    public function update(Request $request, doctors $doctors)
    {
        //dd($doctor);
        try {
            DB::transaction(function () use ($request) {
                $doctor = doctors::findOrFail($request->doctor_id);
                $new_image = $this->ReplaceImg($doctor,$request,'photo','doctors');
                $doctor->act = $request->act;
                $doctor->name_ar = $request->name_ar;
                $doctor->from_time =$request->from_time;
                $doctor->to_time=$request->to_time;
                $doctor->slot_time=$request->slot_time;
                $doctor->user_id=$request->user_id;
                $doctor->phone_number=$request->phone_number;
                $doctor->photo=$new_image;
                $doctor->subgrp= $request->subgrp;
                $doctor->sex=$request->sex;
                $doctor->specialization_ar=$request->specialization_ar;
                $doctor->save();
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => $ex]);
        }

    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store(Request $request)
    {
        $new_image = "";
        try {
            DB::transaction(function () use ($request,$new_image) {
                $user = User::create([
                    'name' => $request->name_ar,
                    'email' => $request->email,
                    'password' => Hash::make($request['password']),
                    'Status'=> $request->Status,
                    'roles_name'=>$request->roles,
                ]);
                $user->assignRole($request->roles);
                if ($request->hasFile('photo')) {
                    $new_image = $this->UploadFile($request, 'photo', 'doctors');
                }
                $doctor = doctors::create([
                    'act' => $request->act,
                    'name_ar' => $request->name_ar,
                    'from_time'=> $request->from_time,
                    'to_time'=> $request->to_time,
                    'slot_time'=> $request->slot_time,
                    'user_id'=> $user->id,
                    'phone_number'=> $user->phone_number,
                    'photo'=> $new_image,
                    'subgrp'=> $request->subgrp,
                    'sex'=> $request->sex,
                    'specialization_ar'=> $request->specialization_ar,
                ]);

                // Doctor Available days
                $mon=0;
                $tue=0;
                $wen=0;
                $thu=0;
                $fri=0;
                $sat=0;
                $sun=0;
                if ($request->mon!=null){
                    $mon=1;
                }
                if ($request->tue!=null){
                    $tue=1;
                }
                if ($request->wen!=null){
                    $wen=1;
                }
                if ($request->thu!=null){
                    $thu=1;
                }
                if ($request->fri!=null){
                    $fri=1;
                }
                if ($request->sat!=null){
                    $sat=1;
                }
                if ($request->sun!=null){
                    $sun=1;
                }

                $availableDay = DoctorAvailableDay::create([
                    'doctor_id'=>$doctor->id,
                    'sun'=>$sun,
                    'mon'=>$mon,
                    'tue'=>$tue,
                    'wen'=>$wen,
                    'thu'=>$thu,
                    'fri'=>$fri,
                    'sat'=>$sat,
                ]);
//                // Doctor available Slots here
                $slot_time = $request->slot_time;
                $start_datetime = Carbon::parse($request->from_time)->format('H:i:s');
                $end_datetime = Carbon::parse($request->to_time)->format('H:i:s');
                $start_datetime_carbon = Carbon::parse($request->from_time);
                $end_datetime_carbon = Carbon::parse($request->to_time);
                $totalDuration = $end_datetime_carbon->diffInMinutes($start_datetime_carbon);
                $totalSlots = $totalDuration / $slot_time;
                for ($a = 0; $a <= $totalSlots; $a++) {
                    $slot_time_start_min = $a * $slot_time;
                    $slot_time_end_min = $slot_time_start_min + $slot_time;
                    $slot_time_start = Carbon::parse($start_datetime)->addMinute($slot_time_start_min)->format('H:i:s');
                    $slot_time_end = Carbon::parse($start_datetime)->addMinute($slot_time_end_min)->format('H:i:s');
                    if ($slot_time_end <= $end_datetime) {
                        // add time slot here
                        $time = $slot_time_start . '<=' . $slot_time_end . '<br>';
                        $availableSlot = new DoctorAvailableSlot();
                        $availableSlot->doctor_id = $doctor->id;
                        $availableSlot->from = $slot_time_start;
                        $availableSlot->to = $slot_time_end;
                        $availableSlot->save();
                    }
                }
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }
    }

    public function destroy($doctors)
    {
        try {
            DB::transaction(function () use ($doctors) {
                $doctor = doctors::findOrFail($doctors)->get();
                if ($doctor->photo !== ""){
                    unlink(public_path('img/'.$doctor->photo));
                }
                doctors::find($doctors)->delete();
                if ($doctor->user_id !== ""){
                    User::find($doctor->user_id)->delete();
                }
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }
    }


}
