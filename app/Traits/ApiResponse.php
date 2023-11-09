<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Api response success
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $data
     * @return JsonResponse
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
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $error
     * @return JsonResponse
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
