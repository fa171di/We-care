<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\gnr_m_areas;
use App\Models\back\gnr_m_cities;
use App\Models\back\gnr_m_clinics;
use App\Models\back\gnr_m_nationality;
use App\Models\back\gnr_m_patients;
use App\Models\User;
use App\Repositories\Patients\IPatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Gnr_m_patientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private IPatientRepository $patientRepository;

    public function __construct(IPatientRepository $PatientRepository)
    {
        $this->patientRepository = $PatientRepository;
    }
    public function index()
    {
        $clinics = gnr_m_clinics::all();
        $patien = $this->patientRepository->index();
        return view('back.patients.index', compact('patien','clinics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $city = gnr_m_cities::all();
        $area = gnr_m_areas::all();
        $nationality = gnr_m_nationality::all();
        $roles = Role::select('id','name')->get();
        return view('back.patients.create', compact('roles','nationality','city','area'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        try {
            $this->patientRepository->store($request);
            return Redirect()->back()->with('success', 'saved success');
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => $ex]);

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
    public function edit(string $id)
    {
        //dd($id);
        $city = gnr_m_cities::all();
        $area = gnr_m_areas::all();
        $nationality = gnr_m_nationality::all();
        $roles = Role::select('id','name')->get();
        $patient = gnr_m_patients::find($id);
        $user = User::find($patient->user_id);
        $prmission =  DB::table('model_has_roles')->where('model_id', '=', $patient->user_id)->get();

        return view('back.patients.edit', compact('prmission','user','patient','roles','nationality','city','area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->patientRepository->update($request,$id);
            return Redirect()->back()->with('success', 'Update success');
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
            return $this->patientRepository->destroy($request);
        } catch (\Exception $ex) {
            return ['result' =>"يوجد خطأ ما",'data' => $ex];

        }
    }
}
