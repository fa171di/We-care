<?php

namespace App\Repositories\Wallet;

use App\Models\back\doctors;
use App\Models\back\gnr_m_areas;
use App\Models\back\gnr_m_cities;
use App\Models\back\gnr_m_nationality;
use App\Models\back\gnr_m_patients;
use App\Models\User;
use App\Repositories\Wallet\IWalletRepository;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WalletRepository implements IWalletRepository
{
    use UploadFileTrait;
    public $wallet;

    public function __construct(gnr_m_patients $patient)
    {
        $this->wallet = $patient;
    }


    public function index()
    {

    }


    public function show($wallet)
    {
        // TODO: Implement show() method.
    }

    public function edit($wallet)
    {
        // TODO: Implement edit() method.
    }

    public function update(Request $request, string $wallet)
    {
       //dd($request);
        $count = 0;
        if ($request->wallet !== null && $request->accountValue !== null){
            if($request->wallet == 0){
                $count = $request->digital_wallet + $request->accountValue;
            }elseif ($request->wallet == 1 && $request->digital_wallet >= $request->accountValue){
                $count = $request->digital_wallet - $request->accountValue;
            }elseif ($request->wallet == 1 && $request->digital_wallet <= $request->accountValue){
                return false;
            }
            //dd($count);
            DB::table('gnr_m_patients')->where('id', $request->id)->update(['digital_wallet' => $count]);
            $pateint = DB::insert('insert into wallet (patient_id, statue,value_changing,prev_value)
                values (?,?,?,?)', [$request->id, $request->wallet, $request->accountValue, $request->digital_wallet]);
            return true;
        }

    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store(Request $request)
    {
        // TODO: Implement store() method.
    }

    public function destroy(Request $request)
    {
        // TODO: Implement destroy() method.
    }
}
