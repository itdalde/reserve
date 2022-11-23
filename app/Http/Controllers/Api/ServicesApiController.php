<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OccasionServiceByProviderRequest;
use App\Http\Requests\OccasionServicesByCompanyRequest;
use App\Http\Requests\OccasionServiceTypeRequest;
use App\Models\Company;
use App\Models\OccasionEvent;
use App\Models\OccasionServiceTypePivot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicesApiController extends Controller
{
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
            ->get(['occasion_service_type_pivots.occasion_id', 'o.name as occasion', 'occasion_service_type_pivots.service_type_id', 'st.name as service_type']);
        return sendResponse($services, 'Services group by occasion');
    }

    /**
     * @param OccasionServiceByProviderRequest $request
     * @return JsonResponse
     */
    public function findOccasionServiceByVendors(OccasionServiceByProviderRequest $request): JsonResponse
    {
        $search = $request->search;
        $serviceId = $request->service_type_id;
        $services = OccasionEvent::with('occasionEventPrice', 'occasionEventsReviews', 'occasionEventsReviewsAverage')
            ->leftJoin('occasion_events_pivots as oep', 'occasion_events.id', '=', 'oep.occasion_event_id')
            ->where('occasion_events.name', 'like', '%' . $search . '%')
            ->where('occasion_events.service_type', '=', $serviceId)
            ->get();
        return sendResponse($services, 'Occasion Service by Providers');
    }

    /**
     * @return JsonResponse
     */
    public function getProviders(): JsonResponse
    {
        $provides = Company::all();
        return sendResponse($provides, 'Event Providers');
    }

    /**
     * @param OccasionServicesByCompanyRequest $request
     * @return JsonResponse
     */
    public function getServicesByCompany(OccasionServicesByCompanyRequest $request): JsonResponse
    {
        $companyId = $request->company_id;
        $services = OccasionEvent::where('company_id', $companyId)->get();
        return sendResponse($services, 'Company Services');
    }
}
