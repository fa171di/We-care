<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ResponseTrait
{
    public function returnError($errNum,$msg){
        return response()->json([
            'success' => false,
            'error' => $errNum,
            'msg' => $msg
        ]);
    }

    public function returnSuccess($msg=""){
        return response()->json([
            'success' => true,
            'error' => 0,
            'msg' => $msg
        ]);
    }

    public function returnData($key,$value,$msg="",$errNum="S00"){
        return response()->json([
            'success' => true,
            'error' => $errNum,
            $key => $value,
            'msg' => $msg
        ]);
    }
}
