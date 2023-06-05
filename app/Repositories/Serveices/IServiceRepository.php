<?php

namespace App\Repositories\Serveices;

use Illuminate\Http\Request;

interface IServiceRepository
{

    public function index();

    public function show($department);

    public function edit(Request $request);

    public function update(Request $request, $doctors);

    public function create();

    public function store(Request $request);

    public function destroy($serves);

}
