<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Occasion;
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
}
