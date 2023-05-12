<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\doctors;
use App\Models\back\gnr_m_clinics;
use App\Repositories\Clinics\IClinicRepository;
use Illuminate\Http\Request;

class Gnr_m_clinicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public IClinicRepository $ClinicRepository;

    public function __construct(IClinicRepository $clinic)
    {
        $this->ClinicRepository = $clinic;
    }

    public function index()
    {
        $departments = $this->ClinicRepository->index();
        return view('back.departments.index', compact('departments'));
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
    public function show(doctors $doctors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(doctors $doctors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, doctors $doctors)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(doctors $doctors)
    {
        //
    }
}
