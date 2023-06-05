<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\cln_m_medical_his;
use App\Models\back\cln_m_services;
use App\Models\back\cln_x_medical_his;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cln_m_medical_hisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if (!empty($request->med1)){
            foreach ($request->med1 as $med1){
                if (DB::table('cln_x_medical_his')->where('patient', '=',$request->patient)->where('med_id', '=',$med1)->count() == 0){
                    DB::insert('insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [1,$med1,$request->patient,$request->note1]);
                }
            }
        }
        if (!empty($request->med2)) {
            foreach ($request->med2 as $med2) {
                if (DB::table('cln_x_medical_his')->where('patient', '=',$request->patient)->where('med_id', '=',$med2)->count() == 0){
                    DB::insert('
insert into cln_x_medical_his (cat ,med_id,patient,note)
 values (?,?,?,?)', [2, $med2, $request->patient,$request->note2]);
                }
            }
        }
        if (!empty($request->med3)) {
            foreach ($request->med3 as $med3) {
                if (DB::table('cln_x_medical_his')->where('patient', '=',$request->patient)->where('med_id', '=',$med3)->count() == 0) {
                    DB::insert(' insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [3, $med3, $request->patient,$request->note3]);
                }
            }
        }
        if (!empty($request->med4)) {
            foreach ($request->med4 as $med4) {
                if (DB::table('cln_x_medical_his')->where('patient', '=',$request->patient)->where('med_id', '=',$med4)->count() == 0) {
                    DB::insert(' insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [4, $med4, $request->patient,$request->note4]);
                }
            }
        }
        if (!empty($request->med5)) {
            foreach ($request->med5 as $med5) {
                if (DB::table('cln_x_medical_his')->where('patient', '=',$request->patient)->where('med_id', '=',$med5)->count() == 0) {
                    DB::insert(' insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [5, $med5, $request->patient,$request->note5]);
                }
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
        $id = $request['medical'];
        $visit = $request['visit'];

        $medicalH =  cln_m_medical_his::select('id','cat','name_ar')->get();

        $visitGet = cln_x_medical_his::where('patient','=',$id)->select('med_id')->get();

        if ($visitGet != null) {
            foreach ($visitGet as $ser) {
                array_push($arr, $ser->med_id);
            }
        }

        return view('back.medical.edit',compact('visit','id','medicalH','arr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /// cln_M_Medical_his

        try {
            DB::table('cln_x_medical_his')->where('patient', '=', $request->patient)->delete();
            if (!empty($request->med1)) {
                foreach ($request->med1 as $med1) {
                    DB::insert('insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [1, $med1, $request->patient, $request->note1]);
                }
            }
            if (!empty($request->med2)) {
                foreach ($request->med2 as $med2) {
                    DB::insert(' insert into cln_x_medical_his (cat ,med_id,patient,note)
                     values (?,?,?,?)', [2, $med2, $request->patient, $request->note2]);

                }
            }
            if (!empty($request->med3)) {
                foreach ($request->med3 as $med3) {
                    DB::insert(' insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [3, $med3, $request->patient, $request->note3]);
                }
            }
            if (!empty($request->med4)) {
                foreach ($request->med4 as $med4) {
                    DB::insert(' insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [4, $med4, $request->patient, $request->note4]);
                }
            }
            if (!empty($request->med5)) {
                foreach ($request->med5 as $med5) {
                    DB::insert(' insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [5, $med5, $request->patient, $request->note5]);
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
    public function destroy(string $id)
    {
        //
    }
}
