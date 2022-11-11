<?php


use Illuminate\Http\JsonResponse;

function sendResponse($result, $message, $code = 200): JsonResponse
{
    $response = [
        'success' => true,
        'data' => $result,
        'message' => $message
    ];

    return response()->json($response, $code);
}

function sendError($error, $message, $code = 404): JsonResponse {
    $response = [
        'success' => false,
        'message' => $error
    ];

    !empty($message) ? $response['data'] = $message : null;

    return response()->json($response, $code);
}
