<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\back\doctors;
use App\Models\back\Question;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Clinics\IClinicRepository;
use App\Repositories\Questions\IQuestionsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiQuestionController extends Controller
{
    use ResponseTrait;

    private IClinicRepository $ClinicRepository;
    private IQuestionsRepository $QuestionsRepository;

    public function __construct(IClinicRepository $ClinicRepository, IQuestionsRepository $QuestionsRepository)
    {
        $this->ClinicRepository = $ClinicRepository;
        $this->QuestionsRepository = $QuestionsRepository;
    }

    public function deps(): JsonResponse
    {
        $departments = $this->ClinicRepository->index();
        if (!$departments) {
            return $this->returnError("D01", "there are no departments");
        } else {
            return $this->returnData("departments", $departments, "", "D00");
        }
    }

    public function store(Request $request): JsonResponse
    {
        $user = auth()->user();
        $userId = $user->id;
        $validator = Validator::make($request->all(), [
            'Question' => 'required',
            'section' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnError("V00", $validator->errors());
        }
        try {
            DB::transaction(function () use ($request, $userId) {
                $question = Question::create([
                    'user_id' => $userId,
                    'Question' => $request->Question,
                    'section' => $request->section
                ]);
            });
            DB::commit();
            return $this->returnSuccess("D00", "Question send successfully..");
        } catch (\Exception $ex) {
            return $this->returnError("V00", $ex->getMessage());
        }
    }

    public function answer(Request $request): JsonResponse
    {
        $user = auth()->user();
        $userId = $user->id;
        $validator = Validator::make($request->all(), [
            'answer' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnError("V00", $validator->errors());
        }
        $question = Question::find($request->id);
        if (!$question) {
            return $this->returnError("D01", "question is not found..");
        } else {
            $question->answer = $request->answer;
            $question->save();
            return $this->returnSuccess("D00", "answered successfully..");
        }
    }

    public function pat_quests(): JsonResponse
    {
        $user = auth()->user();
        $userId = $user->id;
        $questions = $this->QuestionsRepository->userQuestions($userId);
        if ($questions->count() == 0) {
            return $this->returnError("D01", "there are no questions yet ..");
        } else {
            return $this->returnData("questions", $questions, "", "D00");
        }
    }

    public function doc_quests():JsonResponse{
        $user = auth()->user();
        $userId = $user->id;
        $doctor = doctors::with('gnr_m_clinics')->where('user_id',$userId)->first();
        if (!$doctor){
            return $this->returnError("D01","Something went wrong ...");
        }else{
            $dep = $doctor->gnr_m_clinics->id;
            $questions = $this->QuestionsRepository->answerTheQ($dep);
            if ($questions->count() == 0) {
                return $this->returnError("D01", "there are no questions yet ..");
            } else {
                return $this->returnData("questions", $questions, "", "D00");
            }
        }
    }
}
