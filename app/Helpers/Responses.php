<?php

namespace App\Helpers;

class Responses
{
    static public function SUCCESS($message, $data, $httpCode)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $httpCode);
    }

    static public function ERROR($message, $data, $errorCode, $httpCode)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'error_code' => $errorCode
        ], $httpCode);
    }
}
