<?php


use Illuminate\Http\JsonResponse;

/**
 * @param $result
 * @param $message
 * @param int $code
 * @return JsonResponse
 */
function sendResponse($result, $message, int $code = 200): JsonResponse
{
    $response = [
        'success' => true,
        'data' => $result,
        'message' => $message
    ];

    return response()->json($response, $code);
}

/**
 * @param $error
 * @param $message
 * @param int $code
 * @return JsonResponse
 */
function sendError($error, $message, int $code = 404): JsonResponse {
    $response = [
        'success' => false,
        'message' => $error
    ];

    !empty($message) ? $response['data'] = $message : null;

    return response()->json($response, $code);
}
