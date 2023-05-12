<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\cln_m_medical_his_cats;
use App\Models\back\cln_x_visits;
use App\Models\back\doctors;
use App\Models\back\gnr_m_patients;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Cln_m_servicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {/*
        $inputArray = [0,1];

        $doctor = DB::table('doctors')->select('id')->get();
        foreach ($doctor as $f){
            DB::insert('insert into expert_available_days (expert_id,sun,mon,tue,wen,thu,fri,sat)
                values (?,?,?,?,?,?,?,?)', [
                $f->id,
                Arr::random($inputArray),
                Arr::random($inputArray),
                Arr::random($inputArray),
                Arr::random($inputArray),
                Arr::random($inputArray),
                Arr::random($inputArray),
                Arr::random($inputArray)
            ]);

        }*/
         dd(doctors::with('user','gnr_m_clinics')
             ->where('famous' ,'=',0)->get());

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


         response()->json(['visit'=>$request->visit,'clinic'=>$request->clinic,'services'=>$request->services,]);
        try {
            DB::transaction(function () use ($request) {

               // dd($request->visit);
                $visit = cln_x_visits::find($request->visit);
                foreach ($request->services as $serv){
                         DB::insert('insert into cln_x_visits_services (visit_id ,clinic,service,status,patient ,d_start ,srv_type)
                values (?, ?,?,?,?,?,?)', [$visit->id, $request->clinic,$serv, "0",$visit->patient, '0', '0']);

                }
            });
            DB::commit();
            response()->json(['result' =>"تم الحفظ بنجاح",'data' => $request->all()]);
        } catch (\Exception $ex) {

            DB::rollback();
            response()->json(['result' =>"يوجد خطأ ما",'data' => $ex]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dia = "" ;
        $cln_m_medical_his_cats = cln_m_medical_his_cats::all();

        $visit = cln_x_visits::find($id);
        $patient = gnr_m_patients::find($visit->patient);

        $patients_medical_info = $patient->gnr_m_patients_medical_info;
        $patient =  $patient->cln_m_medical_his;
        $services = $visit->cln_m_services;
        $com = $visit->cln_x_prev_com;
        $str = $visit->cln_x_prev_str;
        $cln = $visit->cln_x_prev_cln;
        $note = $visit->cln_x_prev_not;

        if ($visit->cln_m_icd10->isNotEmpty()) {
            $dia = ["icd10",$visit->cln_m_icd10];
        } else {
            $dia = ["dia",$visit->cln_x_prev_dia];
        }
        return view('back.services.index', compact('services','patients_medical_info',
            'patient','cln_m_medical_his_cats','note','com','str','cln','dia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
