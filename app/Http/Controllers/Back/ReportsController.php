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
            $client = new Client();
            $responses = $client->request('GET','http://127.0.0.1:8000/data/'.$data1);
            $diseases = json_decode($responses->getBody(),true);
            dd($diseases) ;

        } catch (\Exception $ex) {

            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }
    public function update(Request $request,string $id){
        try {
            $client = new Client();
            $diseases = $request->input('disease');
            $responses = $client->request('POST', 'http://127.0.0.1:8000/data/', [
                'form_params' => [
                    'disease' => $diseases
                ]
            ]);
            $areas = json_decode($responses->getBody(), true);
            dd($areas);

        } catch (\Exception $ex) {

            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }

}
