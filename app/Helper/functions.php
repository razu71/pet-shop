<?php

use Illuminate\Http\JsonResponse;


function uuid(): \Ramsey\Uuid\UuidInterface {
    return \Ramsey\Uuid\Uuid::uuid4();
}

if (!function_exists('successResponse')) {
    function successResponse($message = 'success', $data = [], int $code = 200): JsonResponse {
        return returnResponse(TRUE, $message, $data, $code);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($message = 'wrong', $data = [], int $code = 400): JsonResponse {
        return returnResponse(FALSE, $message, $data, $code);
    }
}

if (!function_exists('returnResponse')) {
    function returnResponse(bool $status, $message, $data = [], int $code = 200): JsonResponse {
        return response()->json([
            'code'    => $code,
            'success' => $status,
            'message' => __($message),
            'data'    => $data
        ], $code);
    }
}

if (!function_exists('errorReturn')) {
    function errorReturn($message = '', $data = []): array {
        return ['success' => FALSE, 'message' => $message, 'data' => $data];
    }
}

if (!function_exists('successReturn')) {
    function successReturn($message = '', $data = []): array {
        return ['success' => TRUE, 'message' => $message, 'data' => $data];
    }
}
