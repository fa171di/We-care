<?php

namespace App\Repositories\Reviews;

use App\Models\back\Question;
use App\Models\back\doctors;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewRepository implements IReviewRepository
{
    use UploadFileTrait;
    public $review;

    public function __construct(doctors $review)
    {
        $this->review = $review;
    }


    public function index()
    {
       //
    }


    public function store(Request $request)
    {
        $total=0;
        $number=0;

        $doctor = doctors::findOrFail($request->doctor);
        if($request->typeUser == 0){//patine
            $total = $doctor->total_rate + $request->rating;
            $number = $doctor->revisions_num + 1;

        }elseif ($request->typeUser == 1){//admin
            $total = $doctor->total_rate + ($request->rating * 2);
            $number = $doctor->revisions_num + 2;
        }

        try {
            DB::transaction(function () use ($request,$doctor,$total,$number) {
                DB::table('doctors')->where('id', $request->doctor)
                    ->update([
                        'total_rate' => $total,
                        'revisions_num' => $number,
                    ]);
            });
            DB::commit();
            return ['result' =>"تم الحفظ بنجاح",'data' => $doctor->subgrp];
        } catch (\Exception $ex) {
            DB::rollback();
            return ['result' =>"يوجد خطأ ما",'data' => $ex];
        }
    }
}
