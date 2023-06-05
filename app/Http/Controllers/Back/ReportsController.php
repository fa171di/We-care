<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\gnr_m_areas;
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ReportsController extends Controller
{
    public function index()
    {
        $area = gnr_m_areas::all();
        return view('back.reports.index', compact('area'));
    }

    public function store(Request $request){
        try {
            $data1 =  $request->area;

            $response = Http::post('http://localhost:8888/notebooks/Documents/python/python_corrected_v2.ipynb/api/area',[
                'data'=> $data1,
            ]);
            if($response->ok()){
                $date =  json_decode($response->getBody(),true);
                dd($date);
            }else{
                dd('false');
            }



        } catch (\Exception $ex) {

            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }

}
