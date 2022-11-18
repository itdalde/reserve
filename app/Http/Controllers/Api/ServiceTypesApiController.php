<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\JsonResponse;

class ServiceTypesApiController extends Controller
{
    public function getServiceTypes(): JsonResponse
    {
        $serviceTypes = ServiceType::all();
        return sendResponse($serviceTypes, "Service Types");
    }

}
