<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\Ads;
use App\Models\back\Question;
use App\Models\back\gnr_m_areas;
use App\Models\back\gnr_m_cities;
use App\Models\back\gnr_m_clinics;
use App\Models\back\gnr_m_nationality;
use App\Models\back\gnr_m_patients;
use App\Models\User;
use App\Repositories\Ads\IAdsRepository;
use App\Repositories\Patients\IPatientRepository;
use App\Repositories\Wallet\IWalletRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private IAdsRepository $adsRepository;

    public function __construct(IAdsRepository $adsRepository)
    {
        $this->adsRepository = $adsRepository;
    }
    public function index()
    {
        $ads = $this->adsRepository->index();
        return view('back.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->adsRepository->store($request);
            return Redirect()->back()->with('success', 'saved success');
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => $ex]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ads = $this->adsRepository->show($id);
        return view('back.ads.index', compact('ads'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ad = Ads::find($id);

        return view('back.ads.edit',compact('id','ad'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        try {
            $Update = $this->adsRepository->update($request,$id);
            return Redirect('/ads')->with('success', ' updated!');

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
            return $this->adsRepository->destroy($request);
        } catch (\Exception $ex) {
            return ['result' =>"يوجد خطأ ما",'data' => $ex];

        }
    }
}
