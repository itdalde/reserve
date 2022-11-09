<?php

namespace App\Http\Controllers;

use App\Interfaces\OccasionEventInterface;
use App\Models\OccasionEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OccasionEventController extends Controller
{
    private OccasionEventInterface $occasionEventRepository;

    public function __construct(OccasionEventInterface $occasionEventRepository)
    {
        $this->occasionEventRepository = $occasionEventRepository;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function createOrder(Request $request): JsonResponse
    {

        return response()->json([
            'status' => 'success',
            'code' => 201,
            'response' => [
                'data' => $request->request
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getEvents(Request $request): JsonResponse
    {
        $occasion = $this->occasionEventRepository->getEvents();

        return response()->json([
            'status' => 'success',
            'response' => [
                'data' => json_decode($occasion)
            ]
        ]);
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

}
