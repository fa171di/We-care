<?php

namespace App\Repositories\Serveices;

use App\Models\back\cln_m_services;
use App\Models\back\cln_x_visits;
use App\Models\back\cln_x_visits_services;
use App\Models\back\doctors;
use App\Models\back\gnr_m_clinics;
use App\Models\User;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServiceRepository implements IServiceRepository
{
    use UploadFileTrait;
    public $Service;

    public function __construct(cln_m_services $Service)
    {
        $this->Service = $Service;
    }
    public function index()
    {
        return $departments = gnr_m_clinics::all();
    }

    public function show($department)
    {

    }

    public function edit(Request $request)
    {

        $arr = array();
        $clinic = $request['clinic'];
        $patient = $request['service'];
        $visit = $request['visit'];

        $services1 = cln_m_services::all();
        $visitGet = cln_x_visits::find($visit);
        $services = $visitGet->cln_m_services;
        if ($services != null) {
            foreach ($services as $ser) {
                array_push($arr, $ser->id);
            }
        }

        return [$arr,$services1,$visit,$patient,$clinic];
    }

    public function update(Request $request, $doctors)
    {

        try {
            if ($request->services != null) {
                DB::table('cln_x_visits_services')->where('visit_id', '=', $request->visit)->delete();
                foreach ($request->services as $serv) {
                    DB::insert('insert into cln_x_visits_services (visit_id ,clinic,service,patient)
                                          values (?, ?,?,?)', [$request->visit, $request->clinic, $serv, $request->patient]);

                }
            }
            DB::commit();
        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->back()->with(['error' => $ex]);
        }

    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $visit = cln_x_visits::find($request->visit);
                DB::table('cln_x_visits_services')->where('visit_id', '=',$request->visit)->delete();
                foreach ($request->services as $serv){
                    DB::insert('insert into cln_x_visits_services (visit_id ,clinic,service,status,patient ,d_start ,srv_type)
                                          values (?, ?,?,?,?,?,?)', [$visit->id, $request->clinic, $serv, "0", $visit->patient, '0', '0']);

                }
            });
            DB::commit();
            return ['result' =>"تم الحفظ بنجاح",'data' => $request->services];
        } catch (\Exception $ex) {

            DB::rollback();
            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }

    public function destroy($request)
    {
        //$request = request();
        try {
            DB::transaction(function () use ($request) {
                DB::table('cln_x_visits_services')->where('visit_id', '=',$request->visit)
                    ->where('service', '=',$request->input)->delete();

            });
            DB::commit();
            return ['result' =>"تم الحذف بنجاح",'data' => ""];
        } catch (\Exception $ex) {
            DB::rollback();
            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }


}
