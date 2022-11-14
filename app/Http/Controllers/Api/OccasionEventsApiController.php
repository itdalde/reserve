<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventsByOccasionRequest;
use App\Models\Occasion;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class OccasionEventsApiController extends Controller
{

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
            ->join('occasion_events', 'occasion_events.id', '=', 'occasion_events_pivots.occasion_event_id')
            ->where('occasions.id', '=', $occasionType)
            ->orWhere([
                ['occasion_events.availability_start_date', '=', $from],
                ['occasion_events.availability_end_date', '=', $to]
            ])->get();
        return sendResponse($occasions, "Occasion Events");
    }
}
