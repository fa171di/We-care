<?php

namespace App\Traits;

use Illuminate\Http\Request;
use function Pest\Laravel\json;

trait ResponseTrait
{
    public function returnError($errNum, $msg)
    {
        return response()->json([
            'success' => false,
            'error' => $errNum,
            'msg' => $msg
        ]);
    }

    public function returnSuccess($errNum = "", $msg = "")
    {
        return response()->json([
            'success' => true,
            'error' => $errNum,
            'msg' => $msg
        ]);
    }

    public function returnData($key, $value, $msg = "", $errNum = "S00")
    {
        return response()->json([
            'success' => true,
            'error' => $errNum,
            $key => $value,
            'msg' => $msg
        ]);
    }

    public function returnData1($key, $value, $msg = "", $errNum = "S00")
    {
        $var = json([$key=>$value]);
        return response()->json([
            'success' => true,
            'error' => $errNum,
            $key => $value,
            'msg' => $msg
        ]);
    }
}
