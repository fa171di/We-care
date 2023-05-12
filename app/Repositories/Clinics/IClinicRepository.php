<?php

namespace App\Repositories\Clinics;

use Illuminate\Http\Request;

interface IClinicRepository
{

    public function index();

    public function show($department);

    public function edit($doctor);

    public function update(Request $request, $doctors);

    public function create();

    public function store(Request $request);

    public function destroy($doctors);

}
