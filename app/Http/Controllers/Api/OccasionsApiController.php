<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OccasionTypeByOccasionRequest;
use App\Models\Occasion;
use App\Models\OccasionTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OccasionsApiController extends Controller
{

    public function getOccasions(): JsonResponse
    {
        $occasion = Occasion::select(['id', 'name', 'logo', 'active'])->where('active', 1)->get();
        return sendResponse($occasion, 'Get Occasions');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getOccasion(Request $request): JsonResponse
    {
        $occasion = Occasion::select(['id', 'name', 'logo', 'active'])->where('id', $request->id)->get();
        return sendResponse($occasion, 'Get occasion with id :' . $request->id);
    }

    /**
     * @param OccasionTypeByOccasionRequest $request
     * @return JsonResponse
     */
    public function getOccasionTypeByOccasionId(OccasionTypeByOccasionRequest $request): JsonResponse
    {
        $request->validated();
        $occasionId = $request->occasion_type;
        $occasionTypes = OccasionTypes::select(['id', 'name', 'image', 'base_price', 'occasion_id'])->where('occasion_id', $occasionId)->get();
        return sendResponse($occasionTypes, 'Occasion Types');
    }

}
