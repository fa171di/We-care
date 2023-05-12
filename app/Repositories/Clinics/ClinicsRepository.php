<?php

namespace App\Repositories\Clinics;

use App\Models\back\doctors;
use App\Models\back\gnr_m_clinics;
use App\Models\User;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClinicsRepository implements IClinicRepository
{
    use UploadFileTrait;
    public $clinics;

    public function __construct(gnr_m_clinics $clinic)
    {
        $this->clinics = $clinic;
    }
    public function index()
    {
        return $departments = gnr_m_clinics::all();
    }

    public function show($department)
    {

    }

    public function edit($doctor)
    {

    }

    public function update(Request $request, $doctors)
    {


    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store(Request $request)
    {
    }

    public function destroy($doctors)
    {

    }


}
