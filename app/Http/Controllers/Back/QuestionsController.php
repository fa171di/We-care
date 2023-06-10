<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\back\gnr_m_clinics;
use App\Models\back\Question;
use App\Repositories\Questions\IQuestionsRepository;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private IQuestionsRepository $QuestionsRepository;

    public function __construct(IQuestionsRepository $QuestionsRepository)
    {
        $this->QuestionsRepository = $QuestionsRepository;
    }
    public function index()
    {
        $questions = $this->QuestionsRepository->index();
        return view('back.questions.index', compact('questions'));
    }

    public function show(string $id)
    {

        $questions = $this->QuestionsRepository->show($id);
        return view('back.questions.show', compact('questions'));
    }

    public function answerTheQ(string $section){
        $questions = $this->QuestionsRepository->answerTheQ($section);
        return view('back.questions.show', compact('questions'));
    }

    public function userQuestions(string $user){
        $questions = $this->QuestionsRepository->userQuestions($user);
        return view('back.questions.show', compact('questions'));
    }

    public function create()
    {
        $section = gnr_m_clinics::all();
        return view('back.questions.create',compact('section'));
    }

    public function store(Request $request)
    {
        if($request->section !== null && $request->Question !== null){
            try {
                $this->QuestionsRepository->store($request);
                return redirect()->route('questions.show', $request->section)->with('success', ' updated!');

            } catch (\Exception $ex) {
                return redirect()->back()->with(['error' => $ex]);

            }
        }else{
            return redirect()->back()->with(['error' => 'يجب ان تختار القسم و تدخل السؤال']);
        }

    }

    public function edit(string $id)
    {
        $section = gnr_m_clinics::all();
        $qu = Question::find($id);
        return view('back.questions.edit',compact('section','qu'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        try {
            $Update = $this->QuestionsRepository->update($request,$id);
            return redirect()->route('questions.show', $request->section)->with('success', ' updated!');

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
