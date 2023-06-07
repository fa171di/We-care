<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\cln_m_icd10;
use App\Models\back\cln_m_medical_his;
use App\Models\back\cln_m_medical_his_cats;
use App\Models\back\cln_m_services;
use App\Models\back\cln_x_prev_icd10;
use App\Models\back\cln_x_visits;
use App\Models\back\gnr_m_patients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class Medical_fileController extends Controller
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
        //var
        $patient = $request->patient;
        $visit = $request->visit;
        $clinic = $request->clinic;

        //relation
        $cln_m_medical_his_cats = cln_m_medical_his_cats::all();
        $patientinfo = gnr_m_patients::find($patient);
        $patientM = $patientinfo->cln_m_medical_his;
        $patientInfoExiste = $patientinfo->gnr_m_patients_medical_info;


        /*$icd10_1 = cln_m_icd10::where('cat','=','1')->get();
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
        $icd10_22 = cln_m_icd10::where('cat','=','22')->get();*/

        $services = cln_m_services::where('clinic', '=', $clinic)->get();
        $medicalH = cln_m_medical_his::select('id', 'cat', 'name_ar')->get();
        return view('back.services.create', compact(
            'cln_m_medical_his_cats', 'patientInfoExiste', 'patientinfo', 'patientM'
            , 'visit', 'patient', 'clinic', 'services', 'medicalH'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);

        $user = User::find(Auth::id());
        $doctor = $user->doctor;

        /// cln_M_Medical_his
        if (!empty($request->med1)) {
            foreach ($request->med1 as $med1) {
                if (DB::table('cln_x_medical_his')->where('patient', '=', $request->patient)->where('med_id', '=', $med1)->count() == 0) {
                    DB::insert('insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [1, $med1, $request->patient, $request->note1]);
                }
            }
        }
        if (!empty($request->med2)) {
            foreach ($request->med2 as $med2) {
                if (DB::table('cln_x_medical_his')->where('patient', '=', $request->patient)->where('med_id', '=', $med2)->count() == 0) {
                    DB::insert('
insert into cln_x_medical_his (cat ,med_id,patient,note)
 values (?,?,?,?)', [2, $med2, $request->patient, $request->note2]);
                }
            }
        }
        if (!empty($request->med3)) {
            foreach ($request->med3 as $med3) {
                if (DB::table('cln_x_medical_his')->where('patient', '=', $request->patient)->where('med_id', '=', $med3)->count() == 0) {
                    DB::insert(' insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [3, $med3, $request->patient, $request->note3]);
                }
            }
        }
        if (!empty($request->med4)) {
            foreach ($request->med4 as $med4) {
                if (DB::table('cln_x_medical_his')->where('patient', '=', $request->patient)->where('med_id', '=', $med4)->count() == 0) {
                    DB::insert(' insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [4, $med4, $request->patient, $request->note4]);
                }
            }
        }
        if (!empty($request->med5)) {
            foreach ($request->med5 as $med5) {
                if (DB::table('cln_x_medical_his')->where('patient', '=', $request->patient)->where('med_id', '=', $med5)->count() == 0) {
                    DB::insert(' insert into cln_x_medical_his (cat ,med_id,patient,note) values (?,?,?,?)', [5, $med5, $request->patient, $request->note5]);
                }
            }
        }

        //cln_x_prev_com
        if ($request->com != null) {
            foreach ($request->com as $com1) {
                if (DB::table('cln_x_prev_com')->where('visit', '=', $request->visit)->where('val', '=', $com1)->count() == 0 && $com1 != null) {
                    DB::insert('insert into cln_x_prev_com (visit ,patient,doc,val) values (?,?,?,?)', [$request->visit, $request->patient, $doctor->id, $com1]);
                }
            }
        }
        // Cln_X_prev_str
        if ($request->str != null) {
            foreach ($request->str as $com1) {
                if (DB::table('cln_x_prev_str')->where('visit', '=', $request->visit)->where('val', '=', $com1)->count() == 0 && $com1 != null) {
                    DB::insert('insert into cln_x_prev_str (visit ,patient,doc,val) values (?,?,?,?)', [$request->visit, $request->patient, $doctor->id, $com1]);
                }
            }
        }
        //cln_x_prev_cln
        if ($request->cln != null) {
            foreach ($request->cln as $com1) {
                if (DB::table('cln_x_prev_cln')->where('visit', '=', $request->visit)->where('val', '=', $com1)->count() == 0 && $com1 != null) {
                    DB::insert('insert into cln_x_prev_cln (visit ,patient,doc,val) values (?,?,?,?)', [$request->visit, $request->patient, $doctor->id, $com1]);
                }
            }
        }
        //cln_x_prev_icd10
        if ($request->icd10SelectedID != null) {
            foreach ($request->icd10SelectedID as $com1) {
                if (DB::table('cln_x_prev_icd10')->where('visit', '=', $request->visit)->where('opr_id', '=', $com1)->count() == 0) {
                    DB::insert('insert into cln_x_prev_icd10 (visit ,patient,opr_id,doc) values (?,?,?,?)', [$request->visit, $request->patient, $com1, $doctor->id]);
                }
            }
        }
        //cln_x_prev_note
        if ($request->note != null) {
            foreach ($request->note as $com1) {
                if (DB::table('cln_x_prev_not')->where('visit', '=', $request->visit)->where('val', '=', $com1)->count() == 0 && $com1 != null) {
                    DB::insert('insert into cln_x_prev_not (visit ,patient,doc,val) values (?,?,?,?)', [$request->visit, $request->patient, $doctor->id, $com1]);
                }
            }
        }
        //patient info
        if ($request->height !== null) {
            if (DB::table('gnr_m_patients_medical_info')->where('patient', '=', $request->patient)->count() == 0) {
                DB::insert('insert into gnr_m_patients_medical_info (patient,birth_date,sex,height,father_height,mother_height) values (?,?,?,?,?,?)',
                    [$request->patient, $request->birth_date, $request->sex, $request->height, $request->father_height, $request->mother_height]);
            }
        }
        //services
        if ($request->services != null) {
            DB::table('cln_x_visits_services')->where('visit_id', '=', $request->visit)->delete();
            foreach ($request->services as $serv) {
                DB::insert('insert into cln_x_visits_services (visit_id ,clinic,service,status,patient ,d_start ,srv_type)
                                          values (?, ?,?,?,?,?,?)', [$request->visit, $request->clinic, $serv, "0", $request->patient, '0', '0']);

            }
        }
        return redirect()->route('services.show', $request->visit);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
