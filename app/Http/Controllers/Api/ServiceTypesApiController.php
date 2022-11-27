<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OccasionServiceTypePivot;
use App\Models\ServiceType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceTypesApiController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getServices(): JsonResponse
    {
        $serviceTypes = ServiceType::get(['id', 'name', 'active']);
        return sendResponse($serviceTypes, "Service types");
    }

    public function getService(Request $request, $service_type_id)
    {
        $serviceTypes = ServiceType::where('id', $service_type_id)
            ->get(['id', 'name', 'active']);
        return sendResponse($serviceTypes, "Service type by id");
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getServiceTypesByOccasionId(Request $request, $occasion_id): JsonResponse
    {
        $serviceTypes = OccasionServiceTypePivot::leftJoin('occasions as o', 'o.id', '=', 'occasion_service_type_pivots.occasion_id')
            ->leftJoin('service_types as st', 'st.id' , '=', 'occasion_service_type_pivots.service_type_id')
            ->where('occasion_service_type_pivots.occasion_id', $occasion_id)
            ->get(['occasion_service_type_pivots.occasion_id', 'o.name as occasion', 'occasion_service_type_pivots.service_type_id', 'st.name as service_type']);
        return sendResponse($serviceTypes, 'Get services under occasion');
    }
}
