<?php

namespace App\Repositories\Reviews;

use Illuminate\Http\Request;

interface IReviewRepository
{
    public function index();

    public function store(Request $request);

}
