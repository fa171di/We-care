<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\gnr_m_clinics;
use App\Models\back\gnr_m_patients_medical_info;
use App\Repositories\Patients\IPatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Gnr_m_patientsInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function edit(Request $request)
    {
        $id = $request['patients_info'];
        $visit = $request['visit'];

        $info = gnr_m_patients_medical_info::where('patient','=',$id)->first();

        return view('back.info.edit',compact('info','visit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
                DB::table('gnr_m_patients_medical_info')
                    ->where('id', $request->id)
                    ->update(['height' => $request->height,'father_height'=>$request->father_height,'mother_height'=>$request->mother_height]);



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
                DB::table('cln_x_prev_not')->where('id', '=',$request->input)->delete();

            });
            DB::commit();
            return ['result' =>"تم الحذف بنجاح",'data' => ""];
        } catch (\Exception $ex) {
            DB::rollback();
            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }
}
