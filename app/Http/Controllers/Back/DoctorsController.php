<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\DoctorAvailableDay;
use App\Models\back\doctors;
use App\Models\User;
use App\Repositories\Doctors\IDoctorRepository;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use UploadFileTrait;
    private IDoctorRepository $DoctorRepository;

    public function __construct(IDoctorRepository $DoctorRepository)
    {
        $this->DoctorRepository = $DoctorRepository;
    }

    public function index()
    {
        $doctor = $this->DoctorRepository->index();
        return view('back.doctors.index', compact('doctor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $roles = Role::select('id','name')->get();
        $section = $request['section'];
        return view('back.doctors.create', compact('section','roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $clean_data1 = $request->validate(User::rules(), User::messages());
        $clean_data = $request->validate(doctors::rules(), doctors::messages());
        $clean_data2 = $request->validate(DoctorAvailableDay::rules(), DoctorAvailableDay::messages());
        try {
            $this->DoctorRepository->store($request);
            return Redirect()->back()->with('success', ' updated!!!');
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => $ex]);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show($doctors)
    {
        $doctor = $this->DoctorRepository->show($doctors);
        return view('back.doctors.index', compact('doctor','doctors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(doctors $doctor,Request $request)
    {
        $section = $request['section'];
        $doctorAll = $request['doctor'];

        $doctor = $this->DoctorRepository->edit($doctorAll->id);
        $doctorAll = $doctor[0][0];
        $users = $doctor[1];
            return view('back.doctors.edit', compact('doctorAll','section','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, doctors $doctors)
    {
        try {
            $Update = $this->DoctorRepository->update($request,$doctors);
            return Redirect()->back()->with('success', ' updated!');

        } catch (\Exception $ex) {

            return redirect()->back()->with(['error' => $ex]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($doctors)
    {
        try {
            $this->DoctorRepository->destroy($doctors);
            return Redirect()->back()->with('success','User deleted successfully');

        } catch (\Exception $ex) {

            return redirect()->back()->with(['error' => $ex]);

        }

    }
}
