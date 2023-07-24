<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventsByEventTypeRequest;
use App\Http\Requests\EventsByOccasionRequest;
use App\Models\Auth\User\User;
use App\Models\AvailableDates;
use App\Models\Company;
use App\Models\EventImages;
use App\Models\OccasionEvent;
use App\Models\OccasionEventPrice;
use App\Models\OccasionEventReviews;
use App\Models\OccasionServiceTypePivot;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OccasionEventsApiController extends Controller
{

    public function getOccasionEvents(): JsonResponse
    {
        $occasions = OccasionEvent::with('company', 'paymentPlan', 'occasionEventsReviews', 'occasionEventsReviewsAverage', 'gallery')
            ->where('services.active', '=', 1)->get();
        return sendResponse($occasions, 'Occasion Events');
    }

    public function getOccasionEventsByFromToDate(EventsByOccasionRequest $request)
    {
        $occasionEventId = $request->occasion_event_id;
        $fromDate = Carbon::createFromFormat('Y-m-d', $request->date_from);
        $toDate = Carbon::createFromFormat('Y-m-d', $request->date_to);

        $occasions = OccasionEvent::with('company', 'paymentPlan', 'occasionEventsReviews', 'occasionEventsReviewsAverage', 'gallery')
            ->leftJoin('services_pivots as oep', 'services.id', '=', 'oep.occasion_event_id')
            ->where('oep.occasion_id', '=', $occasionEventId)
            ->where('services.availability_start_date', '>=', $fromDate)
            ->where('services.availability_end_date', '<=', $toDate)
            ->get();

        return sendResponse($occasions, "Occasion Events By Occasion Date");
    }

    /**
     * @param EventsByEventTypeRequest $request
     * @return JsonResponse
     */
    public function getOccasionByServiceType(EventsByEventTypeRequest $request): JsonResponse
    {
        $request->validated();
        $serviceType = $request->id;
        $occasions = OccasionEvent::with('company', 'occasionEventsReviews', 'paymentPlan', 'occasionEventsReviewsAverage', 'gallery')
            ->where('service_type', $serviceType)
            ->get();
        return sendResponse($occasions, 'Occasion By Event Type');
    }


    public function getOccasionEventById(Request $request)
    {
        $event = OccasionEvent::with('company', 'occasionEventsReviews', 'paymentPlan', 'occasionEventsReviewsAverage', 'gallery', 'adOns')
            ->where('id', $request->id)
            ->first();
        return sendResponse($event, 'Get occasion event by id');
    }

    public function getOccasionServiceByOccasionId(Request $request, $occasion_event_id)
    {
        $event = OccasionEvent::with('company', 'paymentPlan', 'occasionEventsReviews', 'occasionEventsReviewsAverage', 'gallery')
            ->where('services.id', $occasion_event_id)
            ->where('services.active', '=', 1)->get();
        return sendResponse($event, 'Get service occasion event by occasion Id');
    }

    public function getPreferences(Request $request)
    {
        try {


            $data = (object)$request->availability;
            $events = OccasionEvent::all();

            foreach ($events as $event) {
                $company = Company::where('id', $event->company_id)->first();
                if($company) {
                    $event['company'] = $company;
                    $event['payment_plan'] = OccasionEventPrice::where('occasion_event_id', $event->id)->first();
                    $event['services_reviews'] = OccasionEventReviews::where('occasion_event_id', $event->id)->get();
                    $event['services_reviews_average'] = OccasionEventReviews::where('occasion_event_id', $event->id)->selectRaw('avg(rate) as aggregate, occasion_event_id')->groupBy('occasion_even_id');
                    $event['gallery'] = EventImages::where('occasion_event_id', $event->id)->get();
                    $event['availability'] = AvailableDates::where('service_id', $event->id)
                        ->whereBetween('date', [$data->from, $data->to])
                        ->where('status', 1)
                        ->get();
                }
            }

            return sendResponse($events, 'Availability dates');
        } catch (Exception $ex) {
            return sendError($ex, 'Exception Error', 400);
        }
    }

    public function getOccasionEventsByCompany(Request $request) {
        try {
            $services = OccasionEvent::where('company_id', $request->company_id)->orderby('id', 'ASC')->get();
            return sendResponse($services, 'Occasion Events');
        } catch (Exception $ex) {
            return sendError($ex,'Exception Error', 400);
        }
    }

}
