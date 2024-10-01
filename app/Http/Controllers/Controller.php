<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function returnSuccess($code, $data)
    {
        return response()->json([
            'code' => $code,
            'data' => $data
        ], $code);
    }

    public function returnFail($code, $error)
    {
        return response()->json([
            'code' => $code,
            'error' => $error
        ], $code);
    }
}
