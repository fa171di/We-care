<?php

namespace App\Repositories\Medical_file;

use Illuminate\Http\Request;

interface IMedicalFileRepository
{

    public function index();

    public function show($department);

    public function edit($doctor);

    public function update(Request $request, $doctors);

    public function create();

    public function store(Request $request);

    public function destroy($doctors);

}
