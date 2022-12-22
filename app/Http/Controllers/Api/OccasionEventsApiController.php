<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventsByEventTypeRequest;
use App\Http\Requests\EventsByOccasionRequest;
use App\Models\OccasionEvent;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OccasionEventsApiController extends Controller
{

    public function getOccasionEvents(): JsonResponse
    {
        $occasions = OccasionEvent::with('paymentPlan', 'occasionEventsReviews', 'occasionEventsReviewsAverage', 'gallery')
            ->where('occasion_events.active', '=', 1)->get();
        return sendResponse($occasions, 'Occasion Events');
    }

    public function getOccasionEventsByFromToDate(EventsByOccasionRequest $request)
    {
        $occasionEventId = $request->occasion_event_id;
        $fromDate = Carbon::createFromFormat('Y-m-d', $request->date_from);
        $toDate = Carbon::createFromFormat('Y-m-d', $request->date_to);

        $occasions = OccasionEvent::with('paymentPlan', 'occasionEventsReviews', 'occasionEventsReviewsAverage', 'gallery')
            ->leftJoin('occasion_events_pivots as oep', 'occasion_events.id', '=', 'oep.occasion_event_id')
            ->where('oep.occasion_id', '=', $occasionEventId)
            ->where('occasion_events.availability_start_date', '>=', $fromDate)
            ->where('occasion_events.availability_end_date', '<=', $toDate)
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
        $occasions = OccasionEvent::with('serviceType', 'occasionEventsReviews', 'paymentPlan', 'occasionEventsReviewsAverage', 'gallery')
            ->where('service_type', $serviceType)
            ->get();
        return sendResponse($occasions, 'Occasion By Event Type');
    }


    public function getOccasionEventById(Request $request)
    {
        $event = OccasionEvent::with('occasionEventsReviews', 'paymentPlan', 'occasionEventsReviewsAverage', 'gallery')
            ->where('id', $request->id)
            ->first();
        return sendResponse($event, 'Get occasion event by id');
    }

    public function getOccasionServiceByOccasionId(Request $request, $occasion_event_id)
    {
        $event = OccasionEvent::with('paymentPlan', 'occasionEventsReviews', 'occasionEventsReviewsAverage', 'gallery')
            ->where('occasion_events.id', $occasion_event_id)
            ->where('occasion_events.active', '=', 1)->get();
        return sendResponse($event, 'Get service occasion event by occasion Id');
    }
}
