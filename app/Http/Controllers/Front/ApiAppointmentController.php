<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Appointments\IAppointmentRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ApiAppointmentController extends Controller
{
    use ResponseTrait;
    public $appointment;

    public function __construct(IAppointmentRepository $appointmentRepository)
    {
        $this->AppointmentRepository = $appointmentRepository;
    }


}
