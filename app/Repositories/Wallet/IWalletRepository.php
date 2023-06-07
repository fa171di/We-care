<?php

namespace App\Repositories\Wallet;

use App\Models\back\gnr_m_patients;
use Illuminate\Http\Request;

interface IWalletRepository
{
    public function index();

    public function show($wallet);

    public function edit($wallet);

    public function update(Request $request, string $wallet);

    public function create();

    public function store(Request $request);

    public function destroy(Request $request);

}
