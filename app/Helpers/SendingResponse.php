<?php

namespace App\Helpers;

class SendingResponse
{
    public static function response($status, $message, $data, $token = '', $statusCode)
    {
        return response()->json([
            'status'    => $status,
            'message'   => $message,
            'token'     => $token,
            'data'      => $data,
        ], $statusCode);
    }

    public static function handleException($status, $message)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }
}
