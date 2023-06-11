<?php

namespace App\Http\Controllers\Back;

use App\Clinic;
use App\DoctorAvailableSlot;
use App\Http\Controllers\Controller;
use App\Models\back\Appointment;
use App\Notification;
use App\ReceptionListDoctor;
use App\Repositories\Appointments\IAppointmentRepository;
use App\Traits\UploadFileTrait;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{

    use UploadFileTrait;

    private IAppointmentRepository $AppointmentRepository;

    public function __construct(IAppointmentRepository $appointmentRepository)
    {
        $this->AppointmentRepository = $appointmentRepository;
    }

    public function index(){
        try {
            $user = auth()->user();
            $role = $user->roles_name;
            $appointments = $this->AppointmentRepository->index();
            return view('back.appointment.index', compact('appointments','role'));
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => $ex]);
        }
    }

    public function patient_appointments($id)
    {
        $user = auth()->user();
        $role = $user->roles_name;
        $appointments = $this->AppointmentRepository->patient_appoi($id);
        return view('back.appointment.index', compact('appointments','role'));
    }

    public function filter(Request $request)
    {
        return $request;
    }

    public function appointment_store(Request $request)
    {
        $clean_data = $request->validate(Appointment::rules(), Appointment::messages());
        $input = $request->all();
        try {
            $this->AppointmentRepository->store($input);
            return Redirect()->back()->with('success', ' updated!!!');
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => $ex]);
        }
    }

    public function time_by_slot(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.create')) {
            if ($request->ajax()) {
                $timeId = $request->timeId;
                $doctorId = $request->doctorId;
                $date = $request->dates;
                $dates = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');

                $appointment_slot = DoctorAvailableSlot::with(['appointment' => function ($re) use ($dates) {
                    $re->where('appointment_date', $dates);
                }])
                    ->where('doctor_available_time_id', $timeId)->get();
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Appointment slot find successfully",
                    'data' => [$appointment_slot, $dates, $doctorId]
                ]);
            }
        } else {
            return view('error.403');
        }
    }

    public function cal_appointment_show(Request $request)
    {
        if ($request->ajax()) {
            $user = Sentinel::getUser();
            $userId = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'doctor') {
                $appointment = Appointment::select(DB::raw('count(id) as `total_appointment`'), DB::raw('appointment_date'))
                    ->whereDate('appointment_date', '>=', $request->start)
                    ->whereDate('appointment_date', '<=', $request->end)
                    ->groupBy(DB::raw('appointment_date'))->where('appointment_with', $user->id)->get();
            } elseif ($role == 'patient') {
                $appointment = Appointment::select(DB::raw('count(id) as `total_appointment`'), DB::raw('appointment_date'))
                    ->whereDate('appointment_date', '>=', $request->start)
                    ->whereDate('appointment_date', '<=', $request->end)
                    ->groupBy(DB::raw('appointment_date'))->where('appointment_for', $user->id)->get();
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $userId)->pluck('doctor_id');
                $appointment = Appointment::select(DB::raw('count(id) as `total_appointment`'), DB::raw('appointment_date'))
                    ->whereDate('appointment_date', '>=', $request->start)
                    ->whereDate('appointment_date', '<=', $request->end)
                    ->where(function ($re) use ($userId, $receptionists_doctor_id) {
                        $re->whereIN('appointment_with', $receptionists_doctor_id);
                        $re->orWhereIN('booked_by', $receptionists_doctor_id);
                        $re->orWhere('booked_by', $userId);
                    })
                    ->groupBy(DB::raw('appointment_date'))->get();
            }
            if (empty($appointment)) {
                $response = [
                    'status' => 'error',
                    'message' => 'No Appointments Found On '
                ];
            } else {
                $response = [
                    'role' => $role,
                    'appointments' => $appointment
                ];
            }
            return response()->json($response);
        }
    }

    public function pending_appointment(User $patient)
    {
        $doctors = User::join('doctors', 'users.id', '=', 'doctors.user_id')
            ->get(['users.*', 'doctors.*']);
        $clinics = Clinic::query()->get();
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id) {
                    $re->where('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 0)->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 0, 'appointment_for' => $user_id])->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $pending_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    //$re->whereIN('appointment_with', $receptionists_doctor_id);
                    // $re->orWhereIN('booked_by', $receptionists_doctor_id);
                    // $re->orWhere('booked_by', $user_id);
                })->where('status', 0)->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $pending_appointment = Appointment::with('doctor', 'patient')->where(['status' => 0])->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.pending-appointment', compact('doctors', 'clinics', 'user', 'role', 'pending_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function upcoming_appointment(User $patient)
    {
        $doctors = User::join('doctors', 'users.id', '=', 'doctors.user_id')
            ->get(['users.*', 'doctors.*']);
        $clinics = Clinic::query()->get();
        $user = Sentinel::getUser();
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $Upcoming_appointment = Appointment::where(function ($re) use ($user_id) {
                    $re->orWhere('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time, $user_id) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->where(function ($r) use ($user_id) {
                            $r->orWhere('appointment_with', $user_id);
                            $r->orWhere('booked_by', $user_id);
                        });
                    })->where('status', 0)
                    ->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Upcoming_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where('appointment_for', $user_id)
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time, $user_id) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->where(function ($r) use ($user_id) {
                            $r->where('appointment_for', $user_id);
                        });
                    })->where('status', 0)
                    ->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Upcoming_appointment = Appointment::with('patient', 'doctor', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    //$re->orWhereIN('appointment_with', $receptionists_doctor_id);
                    //$re->orWhere('booked_by', $user_id);
                    //$re->orWhereIN('booked_by', $receptionists_doctor_id);
                })
                    ->whereDate('appointment_date', '>', $today)
                    ->orWhere(function ($re) use ($today, $time) {
                        $re->whereDate('appointment_date', '=', $today);
                        $re->whereTime('available_time', '>=', $time);
                        $re->Where('status', 0);
                    })->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $Upcoming_appointment = Appointment::where('appointment_date', '>', $today)->orWhere(function ($re) use ($today, $time) {
                    $re->whereDate('appointment_date', $today);
                    $re->whereTime('available_time', '>=', $time);
                })
                    ->paginate($this->limit);
            }
            return view('appointment.upcoming-appointment', compact('doctors', 'clinics', 'user', 'role', 'Upcoming_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function complete_appointment(User $patient)
    {
        $doctors = User::join('doctors', 'users.id', '=', 'doctors.user_id')
            ->get(['users.*', 'doctors.*']);
        $clinics = Clinic::query()->get();
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {

            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id) {
                    $re->where('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })->where('status', 1)->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 1, 'appointment_for' => $user_id])->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Complete_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    // $re->whereIN('appointment_with', $receptionists_doctor_id);
                    //$re->orWhereIN('booked_by', $receptionists_doctor_id);
                    //$re->orWhere('booked_by', $user_id);
                })->where('status', 1)->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $Complete_appointment = Appointment::with('doctor', 'patient')->where(['status' => 1])->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.complete-appointment', compact('doctors', 'clinics', 'user', 'role', 'Complete_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function cancel_appointment(User $patient)
    {
        $doctors = User::join('doctors', 'users.id', '=', 'doctors.user_id')
            ->get(['users.*', 'doctors.*']);
        $clinics = Clinic::query()->get();
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            $admin_role = Sentinel::findRoleBySlug('admin');
            $verify_mail = $user->email;
            $app_name = config('app.name');
            if ($role == 'doctor') {
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($user_id) {
                        $re->where('appointment_with', $user_id);
                        $re->orWhere('booked_by', $user_id);
                    })->where('status', 2)
                    ->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['status' => 2, 'appointment_for' => $user_id])->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Cancel_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                    // $re->whereIN('appointment_with', $receptionists_doctor_id);
                    //$re->orWhereIN('booked_by', $receptionists_doctor_id);
                    //$re->orWhere('booked_by', $user_id);
                })->where('status', 2)->orderBy('id', 'DESC')->paginate($this->limit);

            } else {
                $Cancel_appointment = Appointment::with('doctor', 'patient')->where('status', 2)->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.cancel-appointment', compact('doctors', 'clinics', 'user', 'role', 'Cancel_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function today_appointment(User $patient)
    {
        $doctors = User::join('doctors', 'users.id', '=', 'doctors.user_id')
            ->get(['users.*', 'doctors.*']);
        $clinics = Clinic::query()->get();
        $user = Sentinel::getUser();
        if ($user->hasAccess('appointment.list')) {
            $user_id = Sentinel::getUser()->id;
            $role = $user->roles[0]->slug;
            $today = Carbon::today()->format('Y/m/d');
            $time = date('H:i:s');
            if ($role == 'doctor') {
                $Today_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($user_id) {
                        $re->where('appointment_with', $user_id);
                        $re->orWhere('booked_by', $user_id);
                    })
                    ->whereDate('appointment_date', Carbon::today())
                    ->orderBy('id', 'DESC')->paginate($this->limit);
            } elseif ($role == 'patient') {
                $Today_appointment = Appointment::with('doctor', 'patient', 'timeSlot')->where(['appointment_for' => $user_id])->whereDate('appointment_date', Carbon::today())->paginate($this->limit);
            } elseif ($role == 'receptionist') {
                $receptionists_doctor_id = ReceptionListDoctor::where('reception_id', $user_id)->pluck('doctor_id');
                $Today_appointment = Appointment::with('doctor', 'patient', 'timeSlot')
                    ->where(function ($re) use ($user_id, $receptionists_doctor_id) {
                        //$re->whereIN('appointment_with', $receptionists_doctor_id);
                        //$re->orWhereIN('booked_by', $receptionists_doctor_id);
                        //$re->orWhere('booked_by', $user_id);
                    })->whereDate('appointment_date', Carbon::today())->orderBy('id', 'DESC')->paginate($this->limit);
            } else {
                $Today_appointment = Appointment::with('doctor', 'patient')->whereDate('appointment_date', Carbon::today())->orderBy('id', 'DESC')->paginate($this->limit);
            }
            return view('appointment.today-appointment', compact('doctors', 'clinics', 'user', 'role', 'Today_appointment'));
        } else {
            return view('error.403');
        }
    }

    public function patient_appointment()
    {
        $doctors = User::join('doctors', 'users.id', '=', 'doctors.user_id')
            ->get(['users.*', 'doctors.*']);
        $clinics = Clinic::query()->get();
        $user = Sentinel::getUser();
        if ($user->hasAccess('patient-appointment.list')) {
            $role = $user->roles[0]->slug;
            $user_id = Sentinel::getUser()->id;
            $appointment = Appointment::with('doctor', 'timeSlot')->where(['appointment_for' => $user_id])->orderBy('id', 'DESC')->paginate($this->limit);
            return view('patient.patient-appointment', compact('doctors', 'clinics', 'appointment', 'user', 'role'));
        } else {
            return view('error.403');
        }
    }
}
