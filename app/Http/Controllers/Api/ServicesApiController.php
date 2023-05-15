<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OccasionServiceByProviderRequest;
use App\Http\Requests\ProviderByServiceTypeRequest;
use App\Models\Auth\User\User;
use App\Models\Company;
use App\Models\OccasionEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicesApiController extends Controller
{
    /**
     * @param OccasionServiceByProviderRequest $request
     * @return JsonResponse
     */
    public function findOccasionServiceByProvider(OccasionServiceByProviderRequest $request): JsonResponse
    {
        $search = $request->search;
        $serviceId = $request->service_type_id;
        $services = OccasionEvent::with('paymentPlan', 'occasionEventsReviews', 'occasionEventsReviewsAverage', 'gallery')
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
        $providers = Company::all();
        foreach($providers as $provider) {
            $provider->base_price = OccasionEvent::where('company_id', $provider->id)->min('price');
        }
        return sendResponse($providers, 'Event Providers');
    }

    public function getProvidersByServiceType(ProviderByServiceTypeRequest $request, $service_type_id): JsonResponse
    {
        $service_type_id = (int) $service_type_id;
        $providers = [];
        if($service_type_id) {
            $users = User::whereHas('company')->with('roles')->sortable(['email' => 'asc'])->get();
            $usersIds = [];
            foreach ($users as $user) {
                if((!$user->hasRole('superadmin'))) {
                    $usersIds[] = $user->company->id;
                }
            }
            $providers = Company::with('tags', 'serviceType', 'services', 'reviews', 'user', 'user.roles')
                ->whereIn('id',$usersIds)
                ->where('service_type_id',(int) $service_type_id)
                ->get();
            foreach($providers as $k => $provider) {
                $provider->base_price = OccasionEvent::where('company_id', $provider->id)->min('price');
            }
        }
        return sendResponse($providers, 'Get providers by service type');
    }

    public function getServicesByProviders(Request $request, $provider_id)
    {
        $services = OccasionEvent::with('occasionEventsReviews', 'paymentPlan', 'occasionEventsReviewsAverage', 'gallery')
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
        $providers = Company::with('serviceType', 'services')
                ->where('id', $company_id)
                ->where('service_type_id', $service_type)
                ->get();
        foreach($providers as $provider) {
            $provider->base_price = OccasionEvent::where('company_id', $provider->id)->min('price');
        }
        return sendResponse($providers, "Get services by company group by service-type");
    }

}
