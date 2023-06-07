<?php

namespace App\Repositories\Ads;

use Illuminate\Http\Request;

interface IAdsRepository
{
    public function index();

    public function show($ads);

    public function edit($ads);

    public function update(Request $request, string $ads);

    public function create();

    public function store(Request $request);

    public function destroy(Request $request);

}
