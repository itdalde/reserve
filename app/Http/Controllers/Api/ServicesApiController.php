<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OccasionServiceByProviderRequest;
use App\Http\Requests\OccasionServicesByCompanyRequest;
use App\Http\Requests\OccasionServiceTypeRequest;
use App\Http\Requests\ProviderByServiceTypeRequest;
use App\Models\Company;
use App\Models\Occasion;
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
    public function getServicesByOccasionId(OccasionServiceTypeRequest $request): JsonResponse
    {
        $request->validated();
        $services = OccasionServiceTypePivot::leftJoin('occasions as o', 'o.id', '=', 'occasion_service_type_pivots.occasion_id')
            ->leftJoin('service_types as st', 'st.id' , '=', 'occasion_service_type_pivots.service_type_id')
            ->where('occasion_service_type_pivots.occasion_id', $request->id)
            ->get(['occasion_service_type_pivots.occasion_id', 'o.name as occasion', 'occasion_service_type_pivots.service_type_id', 'st.name as service_type']);
        return sendResponse($services, 'Services group by occasion');
    }

    /**
     * @param OccasionServiceByProviderRequest $request
     * @return JsonResponse
     */
    public function findOccasionServiceByProvider(OccasionServiceByProviderRequest $request): JsonResponse
    {
        $search = $request->search;
        $serviceId = $request->service_type_id;
        $services = OccasionEvent::with('occasionEventPrice', 'occasionEventsReviews', 'occasionEventsReviewsAverage')
            ->leftJoin('occasion_events_pivots as oep', 'occasion_events.id', '=', 'oep.occasion_event_id')
            ->where('occasion_events.name', 'like', '%' . $search . '%')
            ->where('occasion_events.service_type', '=', $serviceId)
            ->get();
        return sendResponse($services, 'Search occasion events by wildcard {name} under service type');
    }

    /**
     * @return JsonResponse
     */
    public function getProviders(): JsonResponse
    {
        $provides = Company::all(['id', 'user_id', 'name', 'description', 'logo', 'service_type_id']);
        return sendResponse($provides, 'Event Providers');
    }


    /**
     * @param OccasionServicesByCompanyRequest $request
     * @return JsonResponse
     */
    public function getServicesByCompany(OccasionServicesByCompanyRequest $request): JsonResponse
    {
        $services = OccasionEvent::with('occasionEventPrice', 'occasionEventsReviews', 'occasionEventsReviewsAverage')
        ->where('company_id', $request->id)->get();
        return sendResponse($services, 'Company Services');
    }

    public function getProvidersByServiceType(ProviderByServiceTypeRequest $request, $service_type_id): JsonResponse
    {

        $providers = Company::with('tags', 'serviceType', 'services')
            ->where('service_type_id', $service_type_id)
            ->get();
        return sendResponse($providers, 'Get providers by service type');
    }

    public function getServicesByProviders(Request $request, $provider_id)
    {
        $services = OccasionEvent::with('occasionEventsReviews', 'occasionEventPrice', 'occasionEventsReviewsAverage')
            ->where('company_id', $provider_id)
            ->get();
        return sendResponse($services, 'Get all services by provider');
    }

    /**
     * @param Request $request
     * @param $company_id
     * @param $service_type
     * @return JsonResponse
     */
    public function getServicesByCompanyAndServiceType(Request $request, $company_id, $service_type): JsonResponse
    {
        $services = Company::with('serviceType', 'occasionEvents')
                ->where('id', $company_id)
                ->where('service_type_id', $service_type)
                ->get();
        return sendResponse($services, "Get services by company group by service-type");
    }

}
