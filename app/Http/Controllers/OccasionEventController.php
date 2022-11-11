<?php

namespace App\Http\Controllers;

use App\Http\Requests\OccasionEventByTypeRequest;
use App\Http\Requests\OccasionEventRequest;
use App\Interfaces\OccasionEventInterface;
use App\Interfaces\OccasionEventPriceInterface;
use App\Models\OccasionEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OccasionEventController extends Controller
{
    private OccasionEventInterface $occasionEventRepository;
    private OccasionEventPriceInterface $occasionEventPriceRepository;

    public function __construct(
        OccasionEventInterface $occasionEventRepository,
        OccasionEventPriceInterface $occasionEventPriceRepository,
    )
    {
        $this->occasionEventRepository = $occasionEventRepository;
        $this->occasionEventPriceRepository = $occasionEventPriceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OccasionEvent  $occasionEvent
     * @return \Illuminate\Http\Response
     */
    public function show(OccasionEvent $occasionEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OccasionEvent  $occasionEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(OccasionEvent $occasionEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OccasionEvent  $occasionEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OccasionEvent $occasionEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OccasionEvent  $occasionEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(OccasionEvent $occasionEvent)
    {
        //
    }

    /**
     * Create Event
     *
     * @param OccasionEventRequest $request
     * @return JsonResponse
     */
    public function createOrder(OccasionEventRequest $request): JsonResponse
    {
        $request->validated();

        $event = $this->occasionEventRepository->createEvents($request->all());

        if (!$event) {
            $error = 'Unable to create events';
            return sendError($error, '', 409);
        }
        return sendResponse($event, 'Created Successfully!', 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getEvents(Request $request): JsonResponse
    {
        $occasion = $this->occasionEventRepository->getEvents();

        foreach ($occasion as $key)
        {
            $price_plan = $this->occasionEventPriceRepository->getEventPriceById($key->occasion_id);
        }
        return sendResponse(json_decode($occasion), 'Events Collection');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteEvent(Request $request): JsonResponse
    {
       $eventId = $request->route('id');
       $this->occasionEventRepository->deleteEvent($eventId);
       return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }

    /**
     * @param OccasionEventByTypeRequest $request
     * @return JsonResponse
     */
    public function getEventByType(OccasionEventByTypeRequest $request): JsonResponse
    {
        $request->validated();

        $type = $request->occasion_type;
        $from = $request->from;
        $to = $request->to;

        $events = $this->occasionEventRepository->getOccasionEventByType($type, $from, $to);
        return sendResponse($events, 'Occasion Events Collection');
    }

}
