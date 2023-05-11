<?php

namespace App\Utils;

class ApiResponse
{
    public static function successMessage(string $message)
    {
        return ApiResponse::success([], $message);
    }

    public static function success(mixed $data = [], string $message = "Success")
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    public static function notFound(mixed $data = [], string $message = "Not found")
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], 404);
    }

    public static function notAuthenticated(mixed $data = [], string $message = "Unauthorized")
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], 401);
    }

    public static function errorMessage(string $message)
    {
        return ApiResponse::error([], $message);
    }

    public static function error(mixed $data = [], string $message = "Error")
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], 422);
    }
}
