<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventsByEventTypeRequest;
use App\Http\Requests\EventsByOccasionRequest;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\OccasionEventReviews;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class OccasionEventsApiController extends Controller
{

    public function getOccasions(): JsonResponse
    {
        $occasions = OccasionEvent::select('occasion_events.*', 'occasions.name as occasion_name', 'prices.*', 'reviews.*')
            ->leftJoin('occasion_events_pivots', 'occasion_events_pivots.occasion_event_id', '=', 'occasion_events.id')
            ->leftJoin('occasions', 'occasions.id', '=', 'occasion_events_pivots.occasion_id')
            ->leftJoin('occasion_event_prices as prices', 'prices.occasion_event_id', '=', 'occasion_events.id')
            ->leftJoin('occasion_event_reviews as reviews', 'reviews.occasion_event_id', '=', 'occasion_events.id')
            ->where('occasion_events.active', '=', 1)
            ->get();
        return sendResponse($occasions, 'Occasion Events');
    }

    /**
     * @param EventsByOccasionRequest $request
     * @return JsonResponse
     */
    public function getEventsByOccasion(EventsByOccasionRequest $request): JsonResponse
    {
        $request->validated();
        $occasionType = $request->occasion_id;
        $from = $request->date_from;
        $to = $request->date_to;

        $occasions = OccasionEvent::select('occasion_events.*', 'o.name as occasion_name', 'oer.*', 'oeps.*')
            ->leftJoin('occasion_events_pivots as oep', 'occasion_events.id', '=', 'oep.occasion_event_id')
            ->leftJoin('occasions as o', 'oep.occasion_id', '=', 'o.id')
            ->leftJoin('occasion_event_reviews as oer', 'occasion_events.id', '=', 'oer.occasion_event_id')
            ->leftJoin('occasion_event_prices as oeps', 'occasion_events.id', '=', 'oeps.occasion_event_id')
            ->where('oep.occasion_id', '=', $occasionType)
            ->where('occasion_events.active', '=', 1)
            ->orWhere([
                ['occasion_events.availability_start_date', '=', $from],
                ['occasion_events.availability_end_date', '=', $to]
            ])
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
        $occasions = OccasionEvent::where('service_type', $serviceType)->andWhere('active', '=', 1)->get();
        return sendResponse($occasions, 'Occasion By Events');
    }
}