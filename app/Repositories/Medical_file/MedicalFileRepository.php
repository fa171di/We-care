<?php

namespace App\Repositories\Medical_file;

use App\Models\back\doctors;
use App\Models\back\gnr_m_clinics;
use App\Models\User;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MedicalFileRepository implements IMedicalFileRepository
{
    use UploadFileTrait;
    public $file;
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function index()
    {

    }

    public function show($department)
    {

    }

    public function edit($doctor)
    {

    }

    public function update(Request $request, $doctors)
    {


    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store(Request $request)
    {

        try {
            DB::transaction(function () use ($request) {
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

            });
            DB::commit();
            return $request->patient;
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => $ex]);
        }



    }

    public function destroy($doctors)
    {

    }


}
