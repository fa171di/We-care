<?php

namespace App\Repositories\Appointments;

use App\Models\back\Appointment;
use App\Models\back\doctors;
use Illuminate\Http\Request;

interface IAppointmentRepository
{

    public function pat_appoints();

    public function doc_appoints();

    public function doc_today_appoints();

    public function pat_canceled_appoints();

    public function show($appointment);

    public function doctor_available_days($doc);

    public function slots($doc,$dates);

    public function update($input, Appointment $appointment);

    public function store($input);

    public function destroy($appointment);

    public function cancel_appoint($appointment);

}
