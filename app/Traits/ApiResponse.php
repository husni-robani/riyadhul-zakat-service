<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Api response success
     */
    public function responseSuccess(string $message, int $statusCode, mixed $data): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Api response failed
     */
    public function responseFailed(string $message, int $statusCode, mixed $error): JsonResponse
    {
        return response()->json([
            'status' => 'failed',
            'message' => $message,
            'error' => $error,
        ], $statusCode);
    }
}
