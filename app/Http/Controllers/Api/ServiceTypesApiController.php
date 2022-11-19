<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OccasionServiceTypeRequest;
use App\Models\Occasion;
use App\Models\OccasionServiceTypePivot;
use App\Models\ServiceType;
use Illuminate\Http\JsonResponse;

class ServiceTypesApiController extends Controller
{
    public function getServiceTypes(): JsonResponse
    {
        $serviceTypes = ServiceType::all();
        return sendResponse($serviceTypes, "Service Types");
    }

    /**
     * @param OccasionServiceTypeRequest $request
     * @return JsonResponse
     */
    public function getServiceTypeByOccasionId(OccasionServiceTypeRequest $request): JsonResponse
    {
        $request->validated();
        $services = OccasionServiceTypePivot::with('occasions', 'serviceTypes')->where('occasion_id', $request->occasion_id)->get();
        return sendResponse($services, 'Services by Service Type group by Occasion');
    }

}
