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
    /**
     * @return JsonResponse
     */
    public function checkStatusById(Request $request, $id): JsonResponse
    {
        $stat = 1;
        $response = [
            'status' => 'InActive',
            'is_active' => false,
        ];
        $service = OccasionEvent::where('id', $id)->first();
        $stat = $service && $service->active;
        if($service)  {

            switch ($stat) {
                case 1:
                    break;
            }
        }
        if($service && $service->active == 1) {
            $response['status'] = 'Active';
            $response['is_active'] = true;
        }
        return sendResponse($response, "Service status");
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
        $serviceIds = [];
        foreach ($services as $service) {
            $companyIds[] = $service['company_id'];
            $serviceIds[] = $service['id'];
        }
        $providers = Company::with('tags', 'serviceType', 'services', 'reviews')
            ->whereIn('id',  $companyIds)
            ->get()->toArray();
        foreach($providers as $k => $provider) {
            foreach ($provider['services'] as $key => $service) {
                if(!in_array($service['id'],$serviceIds)) {
//                    unset($provider->services[$key]);
                } else {
                    $providers[$k]['services'] = [];
                    $providers[$k]['base_price'] = $service['price'];
                    $providers[$k]['services'][] = $service;
                    break;
                }
            }
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
