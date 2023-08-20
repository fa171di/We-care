<?php

namespace App\Repositories\Questions;

use App\Models\back\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionsRepository implements IQuestionsRepository
{
    public $Question;

    public function __construct(Question $Question)
    {
        $this->Question = $Question;
    }


    public function index() // get all Questions from all clinic for admin
    {
        return Question::all();
    }


    public function show($Questions) //get all Questions from  clinic that the doctor  auth is in
    {
        return Question::where('section','=',$Questions)->get();
    }

    public function answerTheQ($Questions){ //get all Questions that need answer from  clinic that the doctor  auth is in
        return Question::with('user')->where('section','=',$Questions)->where('answer' ,'=',null)->get();
    }

    public function userQuestions($user){ //get all Questions that user insert
        return Question::with('gnr_m_clinics')->where('user_id','=',$user)
            ->orderByDesc('id')->get();
    }

    public function edit($Questions)
    {
        // TODO: Implement edit() method.
    }

    public function update(Request $request, string $Questions)
    {
        try {
            DB::transaction(function () use ($request,$Questions) {
                $Questions = Question::findOrFail($Questions);
                $Questions->Question = $request->Question;
                $Questions->answer = $request->answer;
                $Questions->section = $request->section;
                $Questions->save();
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => $ex]);
        }

    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store(Request $request)
    {

        try {
            DB::transaction(function () use ($request) {
                Question::create([
                    'user_id'=>Auth::id(),
                    'Question' => $request->Question,
                    'section' => $request->section
                ]);
            });
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => $ex]);
        }

    }

    public function destroy(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if ($request->img !== null){
                    unlink(public_path('img/'.$request->img));
                }
                    DB::table('ads')->where('id', '=', $request->input)->delete();
            });
            DB::commit();
            return ['result' =>"تم الحذف بنجاح",'data' => ""];
        } catch (\Exception $ex) {
            DB::rollback();
            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }
}
