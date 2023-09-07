<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Models\AvailableDates;
use App\Models\Company;
use App\Models\OccasionEvent;
use Carbon\Carbon;
use Google\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvailabilityApiController extends Controller
{
    public function checkAvailableServices(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'from' => 'required',
                'to' => 'required',
            ]);
            if ($validator->fails()) {
                return sendError('Something went wrong', $validator->errors()->all(), 422);
            }
            $occasions = OccasionEvent::join('available_dates', 'services.id', '=', 'available_dates.service_id')
                ->whereBetween('available_dates.date_obj', [$request->from, $request->to])
                ->when($request->service_id, function ($query) use ($request) {
                    return $query->where('services.id', $request->service_id);
                })
                ->where('status', 1)
                ->get();
            foreach ($occasions as $k => $occasion) {
                $occasions[$k]->company = $occasion->company;
                $occasions[$k]->serviceReviews = $occasion->serviceReviews;
                $occasions[$k]->paymentPlan = $occasion->paymentPlan;
                $occasions[$k]->serviceType = $occasion->serviceType;
                $occasions[$k]->gallery = $occasion->gallery;
                $occasions[$k]->availabilities = $occasion->availabilities;
                $occasions[$k]->unavailabilities = $occasion->unavailabilities;
                $occasions[$k]->adOns = $occasion->adOns;
            }
            return sendResponse($occasions, "Events available");
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }
}
