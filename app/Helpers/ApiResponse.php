<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($message)
    {
        return response()->json([
            "success"=> true,
            "message"=> $message
        ]);
    }

    public static function error($message)
    {
        return response()->json([
            "success"=> false,
            "message"=> $message
            ], 400);
    }

    public static function validationError($message)
    {
        return response()->json([
            "success"=> false,
            "message" => $message
        ],422);
    }

    public static function generalError()
    {
        return response()->json([
            "success"=> false,
            "message" => "An unexpected error occured please try again"
            ],500);
    }

    public static function notFound($message){
        return response()->json([
            "success"=> false,
            "message"=> $message
            ],404);
    }
}