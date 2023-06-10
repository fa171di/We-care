<?php

namespace App\Repositories\Questions;

use Illuminate\Http\Request;

interface IQuestionsRepository
{
    public function index();

    public function show($ads);

    public function edit($Questions);

    public function answerTheQ($Questions);

    public function update(Request $request, string $Questions);

    public function create();

    public function store(Request $request);

    public function destroy(Request $request);

}
