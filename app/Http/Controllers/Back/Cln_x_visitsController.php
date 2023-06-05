<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\cln_x_visits;
use App\Models\back\gnr_m_clinics;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cln_x_visitsController extends Controller
{

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
        $visits = DB::table('cln_x_visits')
            ->join('cln_x_prev_com', function (JoinClause $join) {
                //not
                $request = request();
                $user = User::find(Auth::id());
                $doctor = $user->doctor->id;
               if ($request->mounth == null && $request->day == null && ($request->between1 ==null || $request->between2 == null)){
                   $time = $this->getDateLastMounth();
                   $start =$time[0];
                   $end = $time[1];
               }elseif ($request->mounth !== null){
                   $start = $request->mounth."-01 00:00:00";
                   $end = $request->mounth."-30 11:59:00";
               }elseif ($request->day !== null){
                   $start = $request->day." 00:00:00";
                   $end = $request->day." 16:59:00";
               }elseif ($request->between1 !== null && $request->between2 !== null){
                   $start = $request->between1;
                   $end = $request->between2;
               }


                $result = $this->getDateASNmber($start,$end);
                //not
                $join->on('cln_x_visits.id', '=', 'cln_x_prev_com.visit')
                    ->where('cln_x_prev_com.doc', '=', $doctor)
                    ->whereBetween('cln_x_visits.d_start', [$result[0],$result[1]]);


            })
            ->join('gnr_m_patients', function (JoinClause $join){
                $join->on('gnr_m_patients.id', '=', 'cln_x_visits.patient');
            })
            ->selectRaw('cln_x_visits.id,DATE_FORMAT(FROM_UNIXTIME(cln_x_visits.d_start), "%Y-%m-%d") AS date
            ,gnr_m_patients.f_name,cln_x_visits.clinic,cln_x_visits.note,cln_x_visits.price')
            ->distinct('cln_x_visits.id')

            ->paginate(30);

        $price = $visits->sum('price');

        return view('back.visits.show', compact('visits','price'));
    }


    public function show($patient)
    {
        $clinics = gnr_m_clinics::all();
        $visits = cln_x_visits::with('gnr_m_clinics')->where('patient','=',$patient)->get();
        return view('back.visits.index', compact('patient','visits','clinics'));
    }

    public function store(Request $request)
    {
        //dd($request);
        try {
            DB::transaction(function () use ($request) {
                if($request->clinic != null){
                    DB::insert('insert into cln_x_visits (patient, clinic,type,status,note,price,d_start)
                values (?,?,?,?,?,?,?)', [$request->user_id, $request->clinic, 1, 0, $request->note,$request->price,time()]);
                }

            });
            DB::commit();
            if($request->clinic != null) {
                return Redirect("visits/$request->user_id")->with('success', ' Saved!');
            }else{
                return Redirect("visits/$request->user_id")->with('success', ' You have to chose clinic!');
            }
        } catch (\Exception $ex) {
            DB::rollback();
            //return Redirect("patients")->with('error', $ex);

        }

    }

    public function edit(string $id)
    {
        $clinics = gnr_m_clinics::all();
        $visit = cln_x_visits::findOrFail($id);
        return view('back.visits.edit',compact('visit','clinics'));
    }

    public function update(string $id,Request $request)
    {
        try {
            DB::transaction(function () use ($id,$request) {
                if($request->clinic != null){
                    DB::table('cln_x_visits')->where('id', $id)->update([
                            'clinic' => $request->clinic,
                            'note'=>$request->note,
                            'price'=>$request->price]);
                   }

            });
            DB::commit();
            if($request->clinic != null) {
                return Redirect("visits/$request->user_id")->with('success', ' Updated!');
            }else{
                return Redirect("visits/$request->user_id")->with('success', ' You have to chose clinic!');
            }
        } catch (\Exception $ex) {
            DB::rollback();
        }
    }

    public function destroy(Request $request)
    {
        $visit = cln_x_visits::find($request->input);
        $services = $visit->cln_m_services;
        $com = $visit->cln_x_prev_com;
        try {
            DB::transaction(function () use ($request,$services,$com) {
                if ($services->isNotEmpty() == null && $com->isNotEmpty() == null){
                    DB::table('cln_x_visits')->where('id', '=',$request->input)->delete();
                }

            });
            DB::commit();
            if ($services->isNotEmpty() == null && $com->isNotEmpty() == null) {
                return Redirect()->back()->with('success', ' deleted!');
            }elseif ($services->isNotEmpty() !== null || $com->isNotEmpty() !== null){
                return Redirect()->back()->with('success', ' We Can not Delete This Visit!');
            }

        } catch (\Exception $ex) {
            DB::rollback();
        }
    }
}
