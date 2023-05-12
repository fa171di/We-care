<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\cln_x_visits;
use App\Models\back\gnr_m_clinics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cln_x_visitsController extends Controller
{


    public function show($patient)
    {
        $clinics = gnr_m_clinics::all();
        $visits = cln_x_visits::with('gnr_m_clinics')->where('patient','=',$patient)->get();
        return view('back.visits.index', compact('visits','clinics'));
    }

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                DB::insert('insert into cln_x_visits (patient, clinic,type,d_start,status,note,sub_status,new_pat)
                values (?, ?,?,?,?,?,?,?)', [$request->user_id, $request->clinic, '1', "12132324", '0', $request->note, '0', '0']);
            });
            DB::commit();
            return Redirect("visits/$request->user_id")->with('success', ' updated!');
        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect("patients")->with('error', $ex);

        }

    }

    public function destroy(string $id)
    {
        $request = request();
        try {
            DB::transaction(function () use ($request) {
                DB::delete('delete from cln_x_visits where id = ?', [$request->user_id]);
            });
            DB::commit();
            return Redirect()->back()->with('success', ' deleted!');
        } catch (\Exception $ex) {
            DB::rollback();
        }
    }
}
