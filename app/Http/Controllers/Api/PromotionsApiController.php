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
            $data = $request->all();
            $promoSql = Promotions::where('status', 1);
            if (isset($data['from']) && isset($data['to'])) {
                $dateTime = \DateTime::createFromFormat('m/d/Y', $data['from']);
                $data['from'] = $dateTime->format('Y-m-d');
                $dateTime = \DateTime::createFromFormat('m/d/Y', $data['to']);
                $data['to'] = $dateTime->format('Y-m-d');
                $promoSql->whereBetween('start_date', [$data['from'], $data['to']])
                    ->whereBetween('end_date', [$data['from'], $data['to']]);
            }

            $promotions = $promoSql->get();
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
            $response = [];
            $hasPromo = Promotions::where('code', $promotion_code)->first();
            if(!$hasPromo) {
                $response = [
                    'success' => false,
                    'status' => 'fail',
                    'data' => null,
                    'message' => 'Promo not found'
                ];
                return response()->json($response, 422);
            }

            $userPromo = Promotions::leftJoin('user_promotions as up', 'promotions.id', '=', 'up.promotion_id')
                ->where('promotions.code', '=', $promotion_code)
                ->where('up.user_id', '=', $user_id)
                ->first();

            $response = [
                'success' => true,
                'status' => 'success',
                'data' => $hasPromo,
                'user_promo' => $userPromo,
                'message' => 'Fetch promotion by code and user id'
            ];

            return response()->json($response, 200);
        } catch (Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }

    }

}
