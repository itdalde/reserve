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
        $serviceTypes = ServiceType::get(['id', 'name', 'active']);
        return sendResponse($serviceTypes, "Service Types Collection");
    }

    /**
     * @param OccasionServiceTypeRequest $request
     * @return JsonResponse
     */
    public function getServiceTypeByOccasionId(OccasionServiceTypeRequest $request): JsonResponse
    {
        $request->validated();
        $services = OccasionServiceTypePivot::leftJoin('occasions as o', 'o.id', '=', 'occasion_service_type_pivots.occasion_id')
            ->leftJoin('service_types as st', 'st.id' , '=', 'occasion_service_type_pivots.service_type_id')
            ->where('occasion_service_type_pivots.occasion_id', $request->occasion_id)
            ->get(['occasion_service_type_pivots.occasion_id', 'o.name as occasion', 'st.name as service_type']);
        return sendResponse($services, 'Services group by occasion');
    }

}
