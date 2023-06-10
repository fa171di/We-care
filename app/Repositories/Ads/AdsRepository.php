<?php

namespace App\Repositories\Ads;

use App\Models\back\Question;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsRepository implements IAdsRepository
{
    use UploadFileTrait;
    public $ads;

    public function __construct(Question $ads)
    {
        $this->ads = $ads;
    }


    public function index()
    {
        return Question::all();
    }


    public function show($ads)
    {
        return Question::where('statue','=',$ads)->get();
    }

    public function edit($ads)
    {
        // TODO: Implement edit() method.
    }

    public function update(Request $request, string $ads)
    {
        try {
            DB::transaction(function () use ($request,$ads) {
                $ads = Question::findOrFail($ads);
                $new_image = $this->ReplaceImg($ads->img,$request,'img','ads');
                $ads->text = $request->text;
                $ads->img = $new_image;
                $ads->statue = $request->statue;
                $ads->save();
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
        $new_image = null;

        if ($request->hasFile('img')) {
            $new_image = $this->UploadFile($request, 'img', 'ads');
        }
        $ads = Question::create([
            'text' => $request->text,
            'img'=> $new_image,
            'statue	' => $request->statue
        ]);
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
