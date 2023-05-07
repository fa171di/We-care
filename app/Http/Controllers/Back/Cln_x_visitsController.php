<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\cln_x_visits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cln_x_visitsController extends Controller
{


    public function show($patient)
    {
        $patient = cln_x_visits::with('gnr_m_clinics')->where('patient','=',$patient)->get();

        return view('back.visits.index', compact('patient'));
    }

    public function store(Request $request)
    {
        //dd($request);
        try {
            DB::transaction(function () use ($request) {
                $user = cln_x_visits::create([
                    'patient' => $request->user_id,
                    'clinic' => $request->clinic,
                    'type' => 1,
                    'd_start' => now(),
                    'note' => $request->note,
                ]);
                return Redirect()->back()->with('success', ' updated!');
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect()->back()->with('success', ' updated!');

        }

    }
}
