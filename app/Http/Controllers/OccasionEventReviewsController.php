<?php

namespace App\Http\Controllers;

use App\Interfaces\OccasionEventReviewsInterface;
use App\Models\Auth\User\User;
use App\Models\OccasionEventReviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OccasionEventReviewsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = OccasionEventReviews::get();
        return view('admin.reviews.index',compact('reviews'));
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

    public function delete(Request $request)
    {
        OccasionEventReviews::where('id',$request->id)->delete();
        return redirect::back() ;
    }

    public function acceptDeclined(Request $request)
    {
        $review = OccasionEventReviews::where('id',$request->id)->first();
        $review->status = $review->status ? 0 : 1 ;
        $review->save();
        return redirect::back() ;
    }


}
