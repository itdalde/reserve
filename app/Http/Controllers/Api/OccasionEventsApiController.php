<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventsByEventTypeRequest;
use App\Http\Requests\EventsByOccasionRequest;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class OccasionEventsApiController extends Controller
{

    public function getOccasions(): JsonResponse
    {
        $occasions = OccasionEvent::select('occasion_events.*', 'occasions.name as occasion_type')
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
        $occasions = Occasion::join('occasion_events_pivots', 'occasion_events_pivots.occasion_id', '=', 'occasions.id')
            ->leftJoin('occasion_events', 'occasion_events.id', '=', 'occasion_events_pivots.occasion_event_id')
            ->leftJoin('occasion_event_prices as prices', 'prices.occasion_event_id', '=', 'occasion_events.id')
            ->leftJoin('occasion_event_reviews as reviews', 'reviews.occasion_event_id', '=', 'occasion_events.id')
            ->where('occasions.id', '=', $occasionType)
            ->orWhere([
                ['occasion_events.availability_start_date', '=', $from],
                ['occasion_events.availability_end_date', '=', $to]
            ])->get();
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
