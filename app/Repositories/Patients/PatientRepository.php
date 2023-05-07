<?php

namespace App\Repositories\Patients;

use App\Models\back\doctors;
use App\Models\back\gnr_m_areas;
use App\Models\back\gnr_m_cities;
use App\Models\back\gnr_m_nationality;
use App\Models\back\gnr_m_patients;
use App\Models\User;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientRepository implements IPatientRepository
{
    use UploadFileTrait;
    public $patient;

    public function __construct(gnr_m_patients $patient)
    {
        $this->patient = $patient;
    }
    public function index()
    {
        $request = request();
        $query = gnr_m_patients::with('user','gnr_m_cities','gnr_m_areas','gnr_m_nationality')->where('id','=',2045702);

        if($f_name = $request->query('f_name')){
            $query->where('f_name','LIKE',"%{$f_name}%");
        }
        if($l_name = $request->query('l_name')){
            $query->where('l_name','LIKE',"%{$l_name}%");
        }
        if($mobile = $request->query('mobile')){
            $query->where('mobile','=',$mobile);
        }
        return $query->paginate(10);
    }

    public function show($department)
    {
        //return doctors::with('user','cln_m_icd10_md')->where('cln_m_icd10_md_id','=',$department)->get();
    }

    public function edit(gnr_m_patients $doctor)
    {
      /*  $doc = $this->doctor::with('user')->get();
        $user =  User::all();
       return [$doc,$user];*/
    }

    public function update(Request $request, gnr_m_patients $doctors)
    {
        //dd($doctor);
        /*try {
            DB::transaction(function () use ($request) {
                $doctor = doctors::findOrFail($request->doctor_id);
                $new_image = $this->ReplaceImg($doctor,$request,'photo','doctors');
                return $doctor->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'to_time'=> $request->to_time,
                    'slot_time'=> $request->slot_time,
                    'price'=> $request->price,
                    'from_time'=> $request->from_time,
                    'user_id'=> $request->user_id,
                    'birthday'=> date('Y-m-d H:i:s', strtotime($request->birthday)),
                    'description'=> $request->description,
                    'cln_m_icd10_md_id'=> $request->cln_m_icd10_md_id,
                    'phone_number'=> $request->phone_number,
                    'gender'=> $request->gender,
                    'status'=> $request->status,
                    'photo'=> $new_image,
                ]);
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }*/

    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store(Request $request)
    {
       /* $new_image = "";
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
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'to_time'=> $request->to_time,
                    'slot_time'=> $request->slot_time,
                    'price'=> $request->price,
                    'from_time'=> $request->from_time,
                    'user_id'=> $user->id,
                    'birthday'=> date('Y-m-d H:i:s', strtotime($request->birthday)),
                    'description'=> $request->description,
                    'cln_m_icd10_md_id'=> $request->cln_m_icd10_md_id,
                    'phone_number'=> $request->phone_number,
                    'gender'=> $request->gender,
                    'status'=> $request->status,
                    'photo'=> $new_image,
                ]);
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }*/
    }

    public function destroy($doctors)
    {
       /* try {
            DB::transaction(function () use ($doctors) {
                $doctor = doctors::findOrFail($doctors);
                if ($doctor->photo !== ""){
                    unlink(public_path('img/'.$doctor->photo));
                }
                doctors::find($doctors)->delete();
                User::find($doctor->user_id)->delete();
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
        }*/
    }


}
