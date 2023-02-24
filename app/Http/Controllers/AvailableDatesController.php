<?php

namespace App\Http\Controllers;

use App\Models\AvailableDates;
use Illuminate\Http\Request;

class AvailableDatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function availableDates(Request $request) {
        $dates = AvailableDates::where('service_id',$request->service_id)->get()->toArray();
        return json_encode($dates);
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
     * @param  \App\Models\AvailableDates  $availableDates
     * @return \Illuminate\Http\Response
     */
    public function show(AvailableDates $availableDates)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AvailableDates  $availableDates
     * @return \Illuminate\Http\Response
     */
    public function edit(AvailableDates $availableDates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AvailableDates  $availableDates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AvailableDates $availableDates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AvailableDates  $availableDates
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvailableDates $availableDates)
    {
        //
    }
}
