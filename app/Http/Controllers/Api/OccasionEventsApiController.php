<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventsByEventTypeRequest;
use App\Http\Requests\EventsByOccasionRequest;
use App\Http\Requests\OccasionEventsByIdRequest;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\OccasionEventReviews;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class OccasionEventsApiController extends Controller
{

    public function getOccasionEvents(): JsonResponse
    {
        $occasions = OccasionEvent::with('occasionEventPrice', 'occasionEventsReviews', 'occasionEventsReviewsAverage')
            ->where('occasion_events.active', '=', 1)->get();
        return sendResponse($occasions, 'Occasion Events');
    }

    /**
     * @param EventsByOccasionRequest $request
     * @return JsonResponse
     */
    public function getEventsByOccasionDate(EventsByOccasionRequest $request): JsonResponse
    {
        $request->validated();
        $occasionType = $request->occasion_id;
        $from = $request->date_from;
        $to = $request->date_to;

        $occasions = OccasionEvent::with('occasionEventPrice', 'occasionEventsReviews', 'occasionEventsReviewsAverage')
            ->leftJoin('occasion_events_pivots as oep', 'occasion_events.id', '=', 'oep.occasion_event_id')
            ->where('oep.occasion_id', '=', $occasionType)
            ->where('occasion_events.active', '=', 1)
            ->orWhere([
                ['occasion_events.availability_start_date', '=', $from],
                ['occasion_events.availability_end_date', '=', $to]
            ])->get();

        return sendResponse($occasions, "Occasion Events By Occasion Date");
    }

    /**
     * @param OccasionEventsByIdRequest $request
     * @return JsonResponse
     */
    public function getOccasionEventsByOccasionId(OccasionEventsByIdRequest $request): JsonResponse
    {
        $request->validated();
        $occasionId = $request->occasion_event_id;
        $occasions = OccasionEvent::select('occasion_events.*', 'types.name as occasion_type')
            ->leftJoin('occasion_types as types', 'occasion_events.occasion_type', '=', 'types.occasion_id')
            ->where('occasion_events.occasion_type', '=', $occasionId)
            ->where('occasion_events.active', '=', 1)
            ->get();
        return sendResponse($occasions, "Occasion Events By Occasion Type");
    }

    /**
     * @param EventsByEventTypeRequest $request
     * @return JsonResponse
     */
    public function getEventsByEventType(EventsByEventTypeRequest $request): JsonResponse
    {
        $request->validated();
        $serviceType = $request->service_type_id;
        $occasions = OccasionEvent::with('serviceType')
            ->where('occasion_events.service_type', $serviceType)->where('occasion_events.active', '=', 1)->get();
        return sendResponse($occasions, 'Occasion By Events');
    }
}
