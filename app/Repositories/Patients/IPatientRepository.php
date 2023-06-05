<?php

namespace App\Repositories\Patients;

use App\Models\back\gnr_m_patients;
use Illuminate\Http\Request;

interface IPatientRepository
{
    public function index();

    public function show($department);

    public function edit(gnr_m_patients $doctor);

    public function update(Request $request, string $doctors);

    public function create();

    public function store(Request $request);

    public function destroy(Request $request);

    public function cities();

    public function areas($citie);
}
