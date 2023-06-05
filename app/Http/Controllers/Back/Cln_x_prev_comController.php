<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\cln_m_medical_his;
use App\Models\back\cln_m_services;
use App\Models\back\cln_x_prev_com;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class Cln_x_prev_comController extends Controller
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
        $user = User::find(Auth::id());
        $doctor = $user->doctor;

            foreach ($request->com as $com1){
                if (DB::table('cln_x_prev_com')->where('visit', '=',$request->visit)->where('val', '=',$com1)->count() == 0 && $com1 != null){
                    DB::insert('insert into cln_x_prev_com (visit ,patient,doc,val) values (?,?,?,?)', [$request->visit,$request->patient,$doctor->id,$com1]);
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
        $id = $request['com'];
        $visit = $request['visit'];

        $user = User::find(Auth::id());
        $doctor = $user->doctor->id;

        $com = cln_x_prev_com::where('visit','=',$visit)->select('id','val')->get();

        return view('back.com.edit',compact('visit','id','com','doctor'));
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
            DB::table('cln_x_prev_com')->where('visit', '=', $request->visit)->delete();
            if ($request->com != null) {
                foreach ($request->com as $com1) {
                    if($com1 != null){
                        DB::insert('insert into cln_x_prev_com (visit ,patient,doc,val) values (?,?,?,?)', [$request->visit, $request->patient, $doctor->id, $com1]);

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
                DB::table('cln_x_prev_com')->where('id', '=',$request->input)->delete();

            });
            DB::commit();
            return ['result' =>"تم الحذف بنجاح",'data' => ""];
        } catch (\Exception $ex) {
            DB::rollback();
            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }
}
