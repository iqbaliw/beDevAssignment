<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($message, $data = [])
    {
        return response()->json([
            'status' => 200,
            'code' => 1,
            'message' => $message,
            'timestamp' => \Carbon\Carbon::now(),
            'data' => $data
        ], 200);
    }

    public static function created($message, $data = [])
    {
        return response()->json([
            'status' => 201,
            'code' => 1,
            'message' => $message,
            'timestamp' => \Carbon\Carbon::now(),
            'data' => $data
        ], 201);
    }

    public static function notFound($message, $data = [])
    {
        return response()->json([
            'status' => 404,
            'code' => 0,
            'message' => $message,
            'timestamp' => \Carbon\Carbon::now(),
            'data' => $data
        ], 404);
    }

    public static function failed($message)
    {
        return response()->json([
            'status' => 400,
            'code' => 0,
            'message' => $message,
            'timestamp' => \Carbon\Carbon::now(),
            'data' => []
        ], 400);
    }

    public static function unauthorized($message)
    {
        return response()->json([
            'status' => 401,
            'code' => 0,
            'message' => $message,
            'timestamp' => \Carbon\Carbon::now(),
            'data' => []
        ], 401);
    }
    
    public static function forbidden($message)
    {
        return response()->json([
            'status' => 403,
            'code' => 0,
            'message' => $message,
            'timestamp' => \Carbon\Carbon::now(),
            'data' => []
        ], 403);
    }

    public static function internalError($message)
    {
        return response()->json([
            'status' => 500,
            'code' => 0,
            'message' => $message,
            'timestamp' => \Carbon\Carbon::now(),
            'data' => []
        ], 500);
    }
}