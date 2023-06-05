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
        $query = gnr_m_patients::with('user','gnr_m_cities','gnr_m_areas','gnr_m_nationality');

        if ($f_name = $request->query('f_name')) {
            $query->where('f_name', 'LIKE', "%{$f_name}%");
        }

        if ($l_name = $request->query('l_name')) {
            $query->where('l_name', 'LIKE', "%{$l_name}%");
        }

        if ($mobile = $request->query('mobile')) {
            $query->where('mobile', '=', $mobile);
        }
        //$query->where('id', '=', 2120353);
                  $query->orderBy('id','desc');
        return $query->paginate(10);
    }

    public function show($department)
    {
        //return doctors::with('user','cln_m_icd10_md')->where('cln_m_icd10_md_id','=',$department)->get();
    }

    public function edit(gnr_m_patients $doctor)
    {

    }

    public function update(Request $request, string $patient)
    {
        try {
            DB::transaction(function () use ($request,$patient) {
                $user = User::find($request->id);
                $user->update([
                    'name' => $request->f_name,
                    'email' => $request->email,
                    'password' => Hash::make($request['password']),
                    'Status'=> $request->Status,
                ]);

                $user->syncRoles($request->roles);
                DB::table('gnr_m_patients')->where('id', $patient)
                    ->update([
                        'f_name' => $request->f_name,
                        'birth_date' => $request->birth_date,
                        'ft_name' => $request->ft_name,
                        'mother_name' => $request->mother_name,
                        'marital_status' => $request->marital_status,
                        'title' => $request->title,
                        'mobile' => $request->mobile,
                        'phone' => $request->phone,
                        'sex' => $request->sex,
                        'blood' => $request->blood,
                        'nationality' => $request->nationality,
                        'p_city' => $request->p_city,
                        'p_area' => $request->p_area,
                        'address' => $request->address,
                    ]);

            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex;

        }

    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->f_name,
                    'email' => $request->email,
                    'password' => Hash::make($request['password']),
                    'Status'=> $request->Status,
                ]);
                $user->assignRole($request->roles);

                $pateint = DB::insert('insert into gnr_m_patients (f_name, birth_date,ft_name,mother_name,marital_status,
                            title,mobile,phone,sex,blood,nationality,p_city,p_area,address,user_id)
                values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [
                    $request->f_name, $request->birth_date, $request->ft_name, $request->mother_name
                    ,  $request->marital_status,$request->title,$request->mobile,
                    $request->phone,$request->sex,$request->blood,
                    $request->nationality,$request->p_city,
                    $request->p_area,$request->address,$user->id]);


            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex;

        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = gnr_m_patients::find($request->input);
                if ($user->cln_m_medical_his->isEmpty()) {
                    DB::table('gnr_m_patients')->where('id', '=', $request->input)->delete();
                    DB::table('users')->where('id', '=', $user->user_id)->delete();
                }
            });
            DB::commit();
            return ['result' =>"تم الحذف بنجاح",'data' => ""];
        } catch (\Exception $ex) {
            DB::rollback();
            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }

    public function cities(){
        return gnr_m_cities::all();
    }

    public function areas($citie){
        return gnr_m_areas::where('city',$citie)->get();
    }


}
