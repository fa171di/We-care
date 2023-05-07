<?php

namespace App\Repositories\Doctors;

use App\Models\back\doctors;
use App\Models\User;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorRepository implements IDoctorRepository
{
    use UploadFileTrait;
    public $doctor;

    public function __construct(doctors $doctor)
    {
        $this->doctor = $doctor;
    }
    public function index()
    {

        return doctors::with('user','gnr_m_clinics')->get();
        //dd($doctor);
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
                    'name' => $request->first_name .' '.$request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request['password']),
                    'Status'=> $request->Status,
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
                    'user_id'=> $request->id,
                    'phone_number'=> $user->phone_number,
                    'photo'=> $new_image,
                    'subgrp'=> $request->subgrp,
                    'sex'=> $request->sex,
                    'specialization_ar'=> $request->specialization_ar,
                ]);
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
