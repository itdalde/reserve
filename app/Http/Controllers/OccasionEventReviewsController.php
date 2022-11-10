<?php

namespace App\Http\Controllers;

use App\Interfaces\OccasionEventReviewsInterface;
use App\Models\OccasionEventReviews;
use Illuminate\Http\Request;

class OccasionEventReviewsController extends Controller
{

    private OccasionEventReviewsInterface $occasionEventReviewsRepository;

    public function __construct(
        OccasionEventReviewsInterface $occasionEventReviewsRepository
    ) {
        $this->occasionEventReviewsRepository = $occasionEventReviewsRepository;
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
     * @param  \App\Models\OccasionEventReviews  $occasionEventReviews
     * @return \Illuminate\Http\Response
     */
    public function show(OccasionEventReviews $occasionEventReviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OccasionEventReviews  $occasionEventReviews
     * @return \Illuminate\Http\Response
     */
    public function edit(OccasionEventReviews $occasionEventReviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OccasionEventReviews  $occasionEventReviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OccasionEventReviews $occasionEventReviews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OccasionEventReviews  $occasionEventReviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(OccasionEventReviews $occasionEventReviews)
    {
        //
    }
}
