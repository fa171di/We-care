<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\cln_m_medical_his_cats;
use App\Models\back\cln_m_services;
use App\Models\back\cln_x_visits;
use App\Models\back\cln_x_visits_services;
use App\Models\back\doctors;
use App\Models\back\gnr_m_patients;
use App\Models\User;
use App\Repositories\Serveices\IServiceRepository;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class Cln_m_servicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public IServiceRepository $Service;

    public function __construct(IServiceRepository $Service)
    {
        $this->Service = $Service;
    }

    public function getDateASNmber(string $date1,string $date2){
        $result = DB::table('cln_x_visits')
            ->select(DB::raw('UNIX_TIMESTAMP("' . $date1 . '") AS date1 ,UNIX_TIMESTAMP("' . $date2 . '") AS date2',))
            ->first();
           return [$result->date1,$result->date2];
    }
public function getDateLastMounth(){
    $last =Carbon::now()->format('Y-m-d');
    $first = Carbon::createFromFormat('Y-m-d', $last)->subMonth()->format('Y-m-d');
    return $result = [$first,$last];
}


/*
 $start ="2020-07-01 00:00:00";
                $end = "2020-07-30 11:59:00";
 * */
    public function index()
    {



        $allvisit = DB::table('cln_x_visits')
            ->join('cln_x_prev_com', function (JoinClause $join) {
                //not
                $request = request();
                $user = User::find(Auth::id());
                $doctor = $user->doctor->id;

                $time = $this->getDateLastMounth();
                $start =$time[0];
                $end = $time[1];

                $result = $this->getDateASNmber($start,$end);
                //not
                $join->on('cln_x_visits.id', '=', 'cln_x_prev_com.visit')
                    ->where('cln_x_prev_com.doc', '=', $doctor)
                    ->whereBetween('cln_x_visits.d_start', [$result[0],$result[1]]);


            })
            ->selectRaw('cln_x_visits.id,DATE_FORMAT(FROM_UNIXTIME(cln_x_visits.d_start), "%Y-%m-%d") AS date
            ,cln_x_visits.patient,cln_x_visits.clinic,cln_x_visits.note,cln_x_visits.price')
            ->distinct('cln_x_visits.id')

            ->get();


dd($allvisit);
        //dd($allvisit->sum('price'));
       // var_dump($allvisit, DB::getQueryLog());
       /* $stack = array();
        for ($i = 1; $i<3;$i++){
            DB::insert('insert into cln_x_visits_services (visit_id ,clinic,service,status,patient ,d_start ,srv_type)
             values (?, ?,?,?,?,?,?)', [1462090, 25,2232, "0",2120353, '0', '0']);
            $val = cln_x_visits_services::pluck('id')->last();
            array_push($stack,$val);
        }


        dd($stack);*/
        /*
        $inputArray = [0,1];

        $doctor = DB::table('doctors')->select('id')->get();
        foreach ($doctor as $f){
            DB::insert('insert into expert_available_days (expert_id,sun,mon,tue,wen,thu,fri,sat)
                values (?,?,?,?,?,?,?,?)', [
                $f->id,
                Arr::random($inputArray),
                Arr::random($inputArray),
                Arr::random($inputArray),
                Arr::random($inputArray),
                Arr::random($inputArray),
                Arr::random($inputArray),
                Arr::random($inputArray)
            ]);

        }*/
        /* dd(doctors::with('user','gnr_m_clinics')
             ->where('famous' ,'=',0)->get());*/

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $val = $this->Service->store($request);
            return $val;

        } catch (\Exception $ex) {
            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dia = "" ;
        $dia10 = "";
        $cln_m_medical_his_cats = cln_m_medical_his_cats::all();

        $visit = cln_x_visits::find($id);
        $patient = gnr_m_patients::find($visit->patient);
        $visitID = $visit->id;
        $patientId  = $visit->patient;
        $clinic = $visit->clinic;
        $patients_medical_info = $patient->gnr_m_patients_medical_info;
        $patient =  $patient->cln_m_medical_his;
        $services = $visit->cln_m_services;
        $com = $visit->cln_x_prev_com;
        $str = $visit->cln_x_prev_str;
        $cln = $visit->cln_x_prev_cln;
        $note = $visit->cln_x_prev_not;
        if ($visit->cln_m_icd10->isNotEmpty()) {
            $dia10 = $visit->cln_m_icd10;
        }
        if ($visit->cln_x_prev_dia->isNotEmpty()){
            $dia = $visit->cln_x_prev_dia;
        }
        return view('back.services.index', compact('services','patients_medical_info',
       'visitID', 'clinic','dia10',   'patientId', 'patient','cln_m_medical_his_cats','note','com','str','cln','dia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $val = $this->Service->edit($request);

        return view('back.services.edit',
            ['arr'=>$val[0]
            ,'services1' =>$val[1]
            ,'visit'=>$val[2],
            'patient'=>$val[3],
            'clinic'=>$val[4]
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            $val = $this->Service->update($request,$id);
            return redirect()->route('services.show', $request->visit);

        } catch (\Exception $ex) {

            return redirect()->back()->with(['error' => $ex]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $val = $this->Service->destroy($request);
            return $val;

        } catch (\Exception $ex) {
            return ['result' =>"يوجد خطأ ",'data' => $ex];
        }
    }
}
