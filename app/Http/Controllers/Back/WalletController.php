<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\gnr_m_areas;
use App\Models\back\gnr_m_cities;
use App\Models\back\gnr_m_clinics;
use App\Models\back\gnr_m_nationality;
use App\Models\back\gnr_m_patients;
use App\Models\User;
use App\Repositories\Patients\IPatientRepository;
use App\Repositories\Wallet\IWalletRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private IWalletRepository $WalletRepository;

    public function __construct(IWalletRepository $WalletRepository)
    {
        $this->WalletRepository = $WalletRepository;
    }
    public function index()
    {
        $clinics = gnr_m_clinics::all();
        $patien = $this->WalletRepository->index();
        return view('back.patients.index', compact('patien','clinics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $city = gnr_m_cities::all();
        $area = gnr_m_areas::all();
        $nationality = gnr_m_nationality::all();
        $roles = Role::select('id','name')->get();
        return view('back.patients.create', compact('roles','nationality','city','area'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        try {
            $this->WalletRepository->store($request);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //dd($id);
        $patient = gnr_m_patients::select('id','digital_wallet')->where('id', '=', $id)->get();

        return view('back.wallet.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $count =  $this->WalletRepository->update($request,$id);
            if ($count == false){
                return redirect()->back()->with(['error' => 'ليس لديك في حسابك الا','msg'=>$request->digital_wallet]);
            }else{
                return Redirect()->back()->with('success', 'Update success');
            }

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
            return $this->WalletRepository->destroy($request);
        } catch (\Exception $ex) {
            return ['result' =>"يوجد خطأ ما",'data' => $ex];

        }
    }
}
