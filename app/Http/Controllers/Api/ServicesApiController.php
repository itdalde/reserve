<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OccasionServiceByProviderRequest;
use App\Http\Requests\ProviderByServiceTypeRequest;
use App\Models\Auth\User\User;
use App\Models\Company;
use App\Models\OccasionEvent;
use App\Models\OccasionEventReviews;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesApiController extends Controller
{
    /**
     * @param OccasionServiceByProviderRequest $request
     * @return JsonResponse
     */
    public function findOccasionByProvider(OccasionServiceByProviderRequest $request): JsonResponse
    {
        $search = $request->search;
        $serviceId = $request->service_type_id;
        $servicesQuery = OccasionEvent::with('paymentPlan', 'occasionEventsReviews', 'occasionEventsReviewsAverage', 'gallery', 'adOns')
            ->leftJoin('companies', 'companies.id', '=', 'services.company_id');
        if($search && $search != '') {
            $servicesQuery->where('companies.name', 'like', '%' . $search . '%');
        }
        $services = $servicesQuery->where('services.service_type', '=', $serviceId)
            ->get();
        return sendResponse($services, 'Search providers by wildcard {name} under service type');
    }

    /**
     * @param OccasionServiceByProviderRequest $request
     * @return JsonResponse
     */
    public function findOccasionServiceByProvider(OccasionServiceByProviderRequest $request): JsonResponse
    {
        $search = $request->search;
        $serviceId = $request->service_type_id;
        $services = OccasionEvent::with('paymentPlan', 'occasionEventsReviews', 'occasionEventsReviewsAverage', 'gallery', 'adOns')
            ->where('services.name', 'like', '%' . $search . '%')
            ->where('services.service_type', '=', $serviceId)
            ->get();
        return sendResponse($services, 'Search occasion events by wildcard {name} under service type');
    }

    /**
     * @return JsonResponse
     */
    public function getReviewsByServiceId(Request $request, $service_id): JsonResponse
    {
        $services = OccasionEventReviews::where('occasion_event_id', $service_id)->with('user', 'occasionEvent')
            ->orderBy('rate', 'DESC')->get()->toArray();
        usort($services, function ($a, $b) {
            return $a['rate'] <=> $b['rate'];
        });
        return sendResponse($services, 'Fetch all reviews by service ID');
    }
    /**
     * @return JsonResponse
     */
    public function getReviewsByUserId(Request $request, $user_id): JsonResponse
    {
        $services = OccasionEventReviews::where('user_id', $user_id)->with('user', 'occasionEvent')
            ->orderBy('rate', 'DESC')->get()->toArray();
        usort($services, function ($a, $b) {
            return $a['rate'] <=> $b['rate'];
        });
        return sendResponse($services, 'Fetch all reviews by service ID');
    }

    /**
     * @return JsonResponse
     */
    public function getReviewsByProviderId(Request $request, $provider_id): JsonResponse
    {
        $response = OccasionEventReviews::whereIn('provider_id', $provider_id)->with('user', 'occasionEvent')
            ->orderBy('rate', 'DESC')->get()->toArray();
        usort($response, function ($a, $b) {
            return $a['rate'] <=> $b['rate'];
        });
        return sendResponse($response, 'Fetch all reviews by provider ID');
    }

    public function updateReviewToService(Request $request) : JsonResponse {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'rate' => 'required|integer',
        ]);
        if ($validator->fails())  {
            return sendError('Something went wrong',$validator->errors()->all(),422);
        }
        $review = OccasionEventReviews::whereIn('id', $data['id'])->first();
        $review->title = $data['title'] ?? '';
        $review->description = $data['description'] ?? '';
        $review->rate = (int)$data['rate'];
        $review->save();
        return sendResponse($review, 'Review is Updated');
    }
    public function addReviewToService(Request $request) : JsonResponse {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'provider_id' => 'required',
            'user_id' =>  'required',
            'rate' => 'required|integer',
        ]);
        if ($validator->fails())  {
            return sendError('Something went wrong',$validator->errors()->all(),422);
        }
        if(isset($data['service_id'])) {
            $service= OccasionEvent::where('id', $data['service_id'])->first();
            if(!$service) {
                return sendError('Something went wrong','Service is not found on system',422);
            }
        }
        if($data['provider_id']) {
            $service= Company::where('id', $data['provider_id'])->first();
            if(!$service) {
                return sendError('Something went wrong','Provider is not found on system',422);
            }
        }
        $user = User::where('id', $data['user_id'])->first();
        if(!$user) {
            return sendError('Something went wrong','User is not found on system',422);
        }
        $review = new OccasionEventReviews();
        $review->occasion_event_id = $data['service_id'] ?? null;
        $review->provider_id = $data['provider_id'];
        $review->user_id = $data['user_id'];
        $review->title = $data['title'] ?? '';
        $review->description = $data['description'] ?? '';
        $review->rate = (int)$data['rate'];
        $review->save();
        return sendResponse($review, 'Review is added');
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
            $providers = Company::with('tags', 'serviceType', 'services', 'reviews')
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
        $services = OccasionEvent::with('occasionEventsReviews', 'paymentPlan', 'occasionEventsReviewsAverage', 'gallery', 'adOns')
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
