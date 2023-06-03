<?php

namespace App\Repositories\Doctors;

use App\Models\back\doctors;
use Illuminate\Http\Request;

interface IDoctorRepository
{

    public function index();

    public function show($department);

    public function edit($doctor);

    public function update(Request $request, doctors $doctors);

    public function create();

    public function store(Request $request);

    public function search($key);

    public function destroy($doctors);

}
