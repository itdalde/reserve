<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Models\AvailableDates;
use App\Models\Company;
use App\Models\Condition;
use App\Models\Feature;
use App\Models\OccasionEvent;
use App\Models\OccasionEventsPivot;
use App\Models\OccasionServiceTypePivot;
use App\Models\ServiceType;
use App\Models\OccasionEventAddon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceTypesApiController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getServices(Request $request): JsonResponse
    {
        $total = 0;
        $data = $request->all();
        $serviceTypes = [];

        if (isset($data['from']) && isset($data['to'])) {
            $dateTime = \DateTime::createFromFormat('m/d/Y', $data['from']);
            $data['from'] = $dateTime ? $dateTime->format('Y-m-d') : $data['from'];
            $dateTime = \DateTime::createFromFormat('m/d/Y', $data['to']);
            $data['to'] = $dateTime ?  $dateTime->format('Y-m-d') : $data['to'];

            $services = OccasionEvent::join('available_dates as ad', 'ad.service_id', '=', 'services.id')
                ->where('services.active', 1)
                ->where('ad.status', 1)
                ->where('ad.date_obj', '!=', null)
                ->where(function ($query) {
                    $query->has('availabilities')->orWhereHas('unavailabilities');
                })
                ->whereBetween('ad.date_obj', [$data['from'], $data['to']])->
                with(
                    'serviceReviews',
                    'paymentPlan',
                    'serviceType',
                    'ratings',
                    'gallery',
                    'availabilities',
                    'unavailabilities',
                    'totalCompletedOrders',
                    'company',
                    'adOns'
                )
                ->get(['services.*'])
                ->toArray();

            $serviceTypeIds = [];
            foreach ($services as $service) {
                if(!in_array($service['service_type']['id'], $serviceTypeIds)) {
                    $serviceTypeIds[] = $service['service_type']['id'];
                }

            }
            if ($serviceTypeIds) {
                $serviceTypes = ServiceType::where('active', 1)
                    ->whereIn('id', $serviceTypeIds)
                    ->get()
                    ->toArray();
            }
        } else {
            $serviceTypes = ServiceType::where('active', 1)
                ->get()
                ->toArray();

            $serviceTypeIds = array_unique(array_column($serviceTypes, 'id'));

            $services = OccasionEvent::whereIn('service_type', $serviceTypeIds)
                ->where('active', 1)
                ->where(function ($query) {
                    $query->has('availabilities')->orWhereHas('unavailabilities');
                })
                ->with(
                    'serviceReviews',
                    'paymentPlan',
                    'serviceType',
                    'ratings',
                    'gallery',
                    'company',
                    'totalCompletedOrders',
                    'adOns'
                )
                ->get()
                ->toArray();
        }

        $companyIds = array_unique(array_column($services, 'company_id'));

        $providers = Company::with('tags', 'serviceType', 'reviews')
            ->whereIn('id', $companyIds)
            ->get()
            ->toArray();
        $totalByCompany = [];

        foreach ($services as $i => $service) {
            if (isset($service['total_completed_orders']) && $service['total_completed_orders']) {
                foreach ($service['total_completed_orders'] as $r) {
                    $totalByCompany[$service['company_id']] = (float)$r['total'];
                }
            }
        }
        foreach ($serviceTypes as $k => $serviceType) {
            $companies = [];
            foreach ($services as $i => $service) {
                if ($serviceType['id'] == $service['service_type']['id']) {
                    foreach ($providers as $key => $provider) {
                        if ($provider['id'] == $service['company_id']) {
                            $providers[$key]['base_price'] = (double) $provider['base_price'];
                            $availableDateObj = AvailableDates::where('service_id', $service['id'])
                                ->where('status', 1)
                                ->where('date_obj', '<>', null);

                            if (isset($data['from']) && isset($data['to'])) {
                                $availableDateObj->whereBetween('date_obj', [$data['from'], $data['to']]);
                            }

                            $unavailableDates = AvailableDates::where('service_id', $service['id'])
                                ->where('status', 2)
                                ->where('date_obj', '<>', null)
                                ->selectRaw('DATE(date_obj) as date')
                                ->get()
                                ->toArray();
                            $availableDates = $availableDateObj->selectRaw('DATE(date_obj) as date')
                                ->get()
                                ->toArray();
                            $availabilities = [];
                            if ($availableDates) {
                                $availabilities = array_map(function ($item) {
                                    return $item['date'];
                                }, $availableDates);
                            }
                            $unavailabilities = [];
                            if ($unavailableDates) {
                                $unavailabilities = array_map(function ($item) {
                                    return $item['date'];
                                }, $unavailableDates);
                            }
                            $services[$i]['features'] = Feature::where('service_id', $service['id'])
                                ->get()
                                ->toArray();
                            $services[$i]['conditions'] = Condition::where('service_id', $service['id'])
                                ->get()
                                ->toArray();
                            $services[$i]['ad_ons'] = OccasionEventAddon::where('occasion_event_id', $service['id'])->get()->toArray();
                            $services[$i]['availabilities'] = $availabilities;
                            $services[$i]['unavailabilities'] = $unavailabilities;
                            $services[$i]['service_type'] = $serviceType;
                            if(empty($availabilities) && empty($unavailabilities)) {
                                unset($services[$i]);
                            } else {
                                $providers[$key]['services'][] = $services[$i] ;
                                $providers[$key]['total_orders'] = $totalByCompany[$service['company_id']] ?? 0;
                                $companies[] = $providers[$key];
                            }
                        }
                    }
                }
            }

            $serviceTypes[$k]['providers'] = $companies;
        }

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
        $total = 0;
        $serviceTypes = OccasionServiceTypePivot::where('occasion_id', $occasion_type_id)->pluck('service_type_id')->toArray();
        $servicesQuery = OccasionEvent::whereIn('service_type', $serviceTypes)
            ->where(function ($query) {
                $query->has('availabilities')->orWhereHas('unavailabilities');
            })
            ->with(
                'serviceReviews',
                'paymentPlan',
                'serviceType',
                'ratings',
                'gallery',
                'availabilities',
                'unavailabilities',
                'totalCompletedOrders',
                'company',
                'adOns'
            );
        $data = $request->all();
        if (isset($data['from']) && isset($data['to'])) {
            $dateTime = \DateTime::createFromFormat('m/d/Y', $data['from']);
            $data['from'] = $dateTime->format('Y-m-d');
            $dateTime = \DateTime::createFromFormat('m/d/Y', $data['to']);
            $data['to'] = $dateTime->format('Y-m-d');
            $servicesQuery
                ->join('available_dates as ad', 'ad.service_id', '=', 'services.id')->where('ad.status', 1)
                ->where('ad.date_obj', '<>', null)
                ->whereBetween('ad.date_obj', [$data['from'], $data['to']]);
        }
        $services = $servicesQuery->get(['services.*'])->toArray();
        $companyIds = [];
        $serviceIds = [];
        foreach ($services as $service) {
            $companyIds[] = $service['company_id'];
            $serviceIds[] = $service['id'];
        }
        $providers = Company::with('tags', 'serviceType', 'services', 'reviews')
            ->whereIn('id', $companyIds)
            ->get()->toArray();
        foreach ($providers as $k => $provider) {
            foreach ($provider['services'] as $key => $service) {
                $providers[$k]['base_price'] = $service['price'];
                if ($service['active'] == 1) {
                    if(isset($service['total_completed_orders']) && $service['total_completed_orders']) {
                        foreach ($service['total_completed_orders'] as $r) {
                            $total += (float) $r['total'];
                        }
                    }
                    $providers[$k]['services'][$key]['features'] = Feature::where('service_id', $service['id'])
                        ->get()
                        ->toArray();
                    $providers[$k]['services'][$key]['conditions'] = Condition::where('service_id', $service['id'])
                        ->get()
                        ->toArray();
                    $providers[$k]['services'][$key]['adOns'] = OccasionEventAddon::where('occasion_event_id', $service['id'])
                        ->get()
                        ->toArray();
                    $availableDateObj = AvailableDates::where('service_id', $service['id'])
                        ->where('status', 1)
                        ->where('date_obj', '<>', null);
                    if (isset($data['from']) && isset($data['to'])) {
                        $availableDateObj
                            ->whereBetween('date_obj', [$data['from'], $data['to']]);
                    }
                    $availableDates = $availableDateObj->selectRaw('DATE(date_obj) as date')->get()->toArray();
                    $unavailableDates = AvailableDates::where('service_id', $service['id'])
                        ->where('status', 2)
                        ->where('date_obj', '<>', null)
                        ->selectRaw('DATE(date_obj) as date')->get()->toArray();
                    if (empty($availableDates) && empty($unavailableDates)) {
                        unset($providers[$k]['services'][$key]);
                    } else {
                        $providers[$k]['services'][$key]['availabilities'] = array_map(function ($item) {
                            return $item['date'];
                        }, $availableDates);
                        $providers[$k]['services'][$key]['unavailabilities'] = $unavailableDates ? array_map(function ($item) {
                            return $item['date'];
                        }, $unavailableDates) : [];
                    }

                    $providers[$k]['total_orders'] = $total;
                } else {
                    unset($providers[$k]['services'][$key]);
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
        $data = $request->all();
        $serviceTypes = OccasionServiceTypePivot::join('occasions', 'occasions.id', '=', 'occasion_service_type_pivots.occasion_id')
            ->join('service_types', 'service_types.id', '=', 'occasion_service_type_pivots.service_type_id')
            ->join('services', 'services.service_type', '=', 'service_types.id')
            ->join('available_dates as ad', 'ad.service_id', '=', 'services.id')
            ->where('occasion_service_type_pivots.occasion_id', $occasion_id);
        if (isset($data['from']) && isset($data['to'])) {
            $dateTime = \DateTime::createFromFormat('m/d/Y', $data['from']);
            $data['from'] = $dateTime->format('Y-m-d');
            $dateTime = \DateTime::createFromFormat('m/d/Y', $data['to']);
            $data['to'] = $dateTime->format('Y-m-d');
            $serviceTypes->where('ad.status', 1)
                ->where('ad.date_obj', '<>', null)
                ->whereBetween('ad.date_obj', [$data['from'], $data['to']]);
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
