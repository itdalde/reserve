<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Models\Company;
use App\Models\OccasionEvent;
use App\Models\OccasionEventsPivot;
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
        $serviceTypes = ServiceType::where('active', 1)->get(['id', 'name', 'active']);
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
    public function getServicesByOccasionId(Request $request, $occasion_type_id): JsonResponse
    {
        $services = OccasionEvent::where('occasion_type', $occasion_type_id)->get()->toArray();
        $companyIds = [];
        foreach ($services as $service) {
            $companyIds[] = $service['company_id'];
        }
        $providers = Company::with('tags', 'serviceType', 'services', 'reviews')
            ->whereIn('id',  $companyIds)
            ->get();
        foreach($providers as $k => $provider) {
            $provider->base_price = OccasionEvent::where('company_id', $provider->id)->min('price');
        }
        return sendResponse($providers, 'Get services by occasion type');
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getServiceTypesByOccasionId(Request $request, $occasion_id): JsonResponse
    {

        $serviceTypes = OccasionServiceTypePivot::leftJoin('occasions as o', 'o.id', '=', 'occasion_service_type_pivots.occasion_id')
            ->leftJoin('service_types as st', 'st.id', '=', 'occasion_service_type_pivots.service_type_id');

        if ($request->has('from') && $request->has('to')) {
            $serviceTypes = $serviceTypes->leftJoin('available_dates as ad', 'ad.service_id', '=', 'o.id')
                ->where('ad.service_id', $occasion_id)
                ->where('ad.status', 1)
                ->whereBetween('ad.date', [$request->input('from'), $request->input('to')]);
        } else {
            $serviceTypes = $serviceTypes->where('occasion_service_type_pivots.occasion_id', $occasion_id);
        }

        $serviceTypes = $serviceTypes->get(['occasion_service_type_pivots.occasion_id', 'o.name as occasion', 'occasion_service_type_pivots.service_type_id', 'st.name as service_type']);

        return sendResponse($serviceTypes, 'Get services under occasion');
    }
}
