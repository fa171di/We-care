<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\Ads;
use App\Models\back\doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {

        return view('back.ads.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $doctor = $request['doctor'];
        return view('back.review.create',compact('doctor'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        //dd($request);
        $total=0;
        $number=0;

        $doctor = doctors::findOrFail($request->doctor);
        if($request->typeUser == 0){//patine
           $total = $doctor->total_rate + $request->rating;
           $number = $doctor->revisions_num + 1;

        }elseif ($request->typeUser == 1){//admin
            $total = $doctor->total_rate + ($request->rating * 2);
            $number = $doctor->revisions_num + 2;
        }

        try {
            DB::transaction(function () use ($request,$doctor,$total,$number) {
                DB::table('doctors')->where('id', $request->doctor)
                    ->update([
                        'total_rate' => $total,
                        'revisions_num' => $number,
                    ]);
            });
            DB::commit();
            return redirect()->route('doctors.show', $doctor->subgrp);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => $ex]);
        }
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

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

    }
}
