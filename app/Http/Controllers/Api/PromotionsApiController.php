<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotions;
use App\Models\UserPromotions;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromotionsApiController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPromotionsList(Request $request): JsonResponse
    {
        try {
            $promotions = Promotions::all();
            return sendResponse($promotions, "Get promotions list");
        } catch (Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }

    }

    /**
     * @return JsonResponse
     */
    public function getPromotionByCode(Request $request, $promotion_code): JsonResponse
    {
        try {
            $response = Promotions::where('code', $promotion_code)->first();
            return sendResponse($response, 'Fetch promotion by code');
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }

    }

    /**
     * @return JsonResponse
     */
    public function getPromotionByUserAndCode(Request $request, $user_id, $promotion_code): JsonResponse
    {
        try {
            $response = Promotions::leftJoin('user_promotions as up', 'promotions.id', '=', 'up.promotion_id')
                ->where('promotions.code', '=', $promotion_code)
                ->where('up.user_id', '=', $user_id)
                ->first();
            return sendResponse($response, 'Fetch promotion by code and user id');
        } catch (Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }

    }

}
