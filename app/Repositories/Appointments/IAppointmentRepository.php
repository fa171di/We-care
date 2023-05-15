<?php

namespace App\Repositories\Appointments;

use App\Models\back\Appointment;
use App\Models\back\doctors;
use Illuminate\Http\Request;

interface IAppointmentRepository
{

    public function index();

    public function show($appointment);

    public function edit($appointment);

    public function update(Request $request, Appointment $appointment);

    public function create();

    public function store(Request $request);

    public function destroy($appointment);

}
