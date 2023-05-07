<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\gnr_m_clinics;
use App\Repositories\Patients\IPatientRepository;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
