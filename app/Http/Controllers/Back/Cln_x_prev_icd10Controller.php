<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\cln_m_icd10;
use App\Models\back\cln_m_medical_his;
use App\Models\back\cln_m_services;
use App\Models\back\cln_x_prev_dia;
use App\Models\back\cln_x_prev_icd10;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class Cln_x_prev_icd10Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $icd10_1 = cln_m_icd10::select('id','name_ar')->where('cat','=',$request->dia)->get();
        return $icd10_1;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $user = User::find(Auth::id());
        $doctor = $user->doctor;

            foreach ($request->icd10SelectedID as $com1){
                if (DB::table('cln_x_prev_icd10')->where('visit', '=',$request->visit)->where('opr_id', '=',$com1)->count() == 0){
                    DB::insert('insert into cln_x_prev_icd10 (visit ,patient,opr_id,doc) values (?,?,?,?)', [$request->visit,$request->patient,$com1,$doctor->id]);
                }
            }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $arr = array();
        $id = $request['dium'];
        $visit = $request['visit'];

        $user = User::find(Auth::id());
        $doctor = $user->doctor->id;

        $icd10_1 = cln_m_icd10::where('cat','=','1')->get();
        $icd10_2 = cln_m_icd10::where('cat','=','2')->get();
        $icd10_3 = cln_m_icd10::where('cat','=','3')->get();
        $icd10_4 = cln_m_icd10::where('cat','=','4')->get();
        $icd10_5 = cln_m_icd10::where('cat','=','5')->get();
        $icd10_6 = cln_m_icd10::where('cat','=','6')->get();
        $icd10_7 = cln_m_icd10::where('cat','=','7')->get();
        $icd10_8 = cln_m_icd10::where('cat','=','8')->get();
        $icd10_9 = cln_m_icd10::where('cat','=','9')->get();
        $icd10_10 = cln_m_icd10::where('cat','=','10')->get();
        $icd10_11 = cln_m_icd10::where('cat','=','11')->get();
        $icd10_12 = cln_m_icd10::where('cat','=','12')->get();
        $icd10_13 = cln_m_icd10::where('cat','=','13')->get();
        $icd10_14 = cln_m_icd10::where('cat','=','14')->get();
        $icd10_15 = cln_m_icd10::where('cat','=','15')->get();
        $icd10_16 = cln_m_icd10::where('cat','=','16')->get();
        $icd10_17 = cln_m_icd10::where('cat','=','17')->get();
        $icd10_18 = cln_m_icd10::where('cat','=','18')->get();
        $icd10_19 = cln_m_icd10::where('cat','=','19')->get();
        $icd10_20 = cln_m_icd10::where('cat','=','20')->get();
        $icd10_21 = cln_m_icd10::where('cat','=','21')->get();
        $icd10_22 = cln_m_icd10::where('cat','=','22')->get();


            $dia = cln_x_prev_dia::where('visit','=',$visit)->select('id','val')->get();
            $dia10 = cln_x_prev_icd10::where('visit','=',$visit)->select('opr_id')->get();
            if ($dia10 != null) {
                foreach ($dia10 as $ser) {
                    array_push($arr, $ser->opr_id);
                }
            }


        return view('back.dia.edit',compact(
            'icd10_1','icd10_2','icd10_3','icd10_4','icd10_5','icd10_6','icd10_7','icd10_8','icd10_9',
            'icd10_10','icd10_11','icd10_12','icd10_13','icd10_14','icd10_15','icd10_16','icd10_17','icd10_18','icd10_19',
            'icd10_20','icd10_21','icd10_22',
            'arr','visit','id','dia','doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request);
        $user = User::find(Auth::id());
        $doctor = $user->doctor;
        try {
            DB::table('cln_x_prev_dia')->where('visit', '=', $request->visit)->delete();
            if ($request->has('dia')) {
                foreach ($request->dia as $com1) {
                    if ($com1 != null) {
                        DB::insert('insert into cln_x_prev_dia (visit ,patient,doc,val) values (?,?,?,?)', [$request->visit, $request->patient, $doctor->id, $com1]);

                    }
                }
            }
            DB::table('cln_x_prev_icd10')->where('visit', '=', $request->visit)->delete();
            if ($request->has('dia10')) {
                foreach ($request->dia10 as $com1) {
                    if ($com1 != null) {
                        DB::insert('insert into cln_x_prev_icd10 (visit ,patient,opr_id,doc) values (?,?,?,?)', [$request->visit,$request->patient,$com1,$doctor->id]);

                    }
                }
            }


            return redirect()->route('services.show', $request->visit);

        } catch (\Exception $ex) {

            return redirect()->back()->with(['error' => $ex]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if ($request->has('dia')){
                    DB::table('cln_x_prev_dia')->where('id', '=',$request->dia)->delete();
                }
                if ($request->has('dia10')){
                    DB::table('cln_x_prev_icd10')->where('visit', '=',$request->visit)->where('opr_id', '=',$request->dia10)->delete();
                }

            });
            DB::commit();
            return ['result' =>"تم الحذف بنجاح",'data' => ""];
        } catch (\Exception $ex) {
            DB::rollback();
            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }
}
