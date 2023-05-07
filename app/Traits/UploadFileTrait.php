<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadFileTrait
{

    public function UploadFile(Request $request,$FieldName,$folderName){
        $name = $request->file($FieldName)->getClientOriginalName();
        $path = $request->file($FieldName)->store($folderName,"imgFile");
        return $path;
    }

    public function ReplaceImg($objectModel,$request,$FieldName,$folderName){
        $new_image = '';
        $old_image = $objectModel->photo;
        if ($request->hasFile($FieldName)){
            if($old_image){
                unlink(public_path('img/'.$old_image));
            }
            $new_image = $this->UploadFile($request,$FieldName,$folderName);
        }
        return $new_image;
    }
}
