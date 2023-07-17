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
        $service = OccasionEvent::where('id', $id)->first();
        $stat = $service && $service->active ? $service->active : 0;
        switch ($stat) {
            case 1:
                $status = 'Published';
                $isActive = true;
                break;
            case 2:
                $status = 'Paused';
                $isActive = true;
                break;
            case 3:
                $status = 'Saved';
                $isActive = true;
                break;
            default :
                $status = 'InActive';
                $isActive = false;
        }
        $response = [
            'status' => $status,
            'is_active' => $isActive,
        ];
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
        $serviceTypes = OccasionServiceTypePivot::where('occasion_id',$occasion_type_id)->pluck('service_type_id')->toArray();
        $services = OccasionEvent::whereIn('service_type', $serviceTypes)->get()->toArray();
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

        $serviceTypes = OccasionServiceTypePivot::join('occasions', 'occasions.id', '=', 'occasion_service_type_pivots.occasion_id')
            ->join('service_types','service_types.id','=','occasion_service_type_pivots.service_type_id')
            ->join('services','services.service_type','=','service_types.id')
            ->leftJoin('available_dates as ad', 'ad.service_id', '=', 'services.id')
            ->where('occasion_service_type_pivots.occasion_id', $occasion_id);
        if (isset($data['from']) && isset($data['to'])) {
            $serviceTypes->where('ad.status', 1)
                ->where('ad.date_obj','<>', null)
                ->whereBetween('ad.date_obj', [$request->input('from'), $request->input('to')]);
        }

        $serviceTypes = $serviceTypes->get(['ad.date_obj AS available_date', 'occasion_service_type_pivots.occasion_id', 'occasions.name as occasion', 'occasion_service_type_pivots.service_type_id', 'service_types.name as service_type'])->toArray();

        $response = [];
        foreach ($serviceTypes as $item) {
            $serviceTypeId = $item['service_type_id'];
            if (isset($response[$serviceTypeId])) {
                $item['available_date'] ? $response[$serviceTypeId]['available_date'][] = $item['available_date'] : '';
            } else {
                $response[$serviceTypeId] = $item;
                $item['available_date'] ? $response[$serviceTypeId]['available_date'] = [$item['available_date']] : '';
            }
        }


        return sendResponse(array_values($response), 'Get services under occasion');
    }
}
