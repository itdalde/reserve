<?php

namespace App\Http\Controllers;

use App\Models\Occasion;
use Illuminate\Http\Request;

class OccasionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->search) {
            $occasions = Occasion::where('name','like','%'.$request->search.'%')
                ->with('occasionEvents','occasionEventsReviews','transactions','transactions.user','transactions.status','transactions.plan')
                ->get()->toArray();
        } else {
            $occasions = Occasion::all()
                ->with('occasionEvents','occasionEventsReviews','transactions','transactions.user','transactions.status','transactions.plan')
                ->toArray();
        }
        if ($request->expectsJson()) {
            return response()->json([
                "status"    => "success" ,
                "response"  => [
                    "data"  => $occasions
                ]
            ]);
        }
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
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\Response
     */
    public function show(Occasion $occasion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\Response
     */
    public function edit(Occasion $occasion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Occasion $occasion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Occasion $occasion)
    {
        //
    }
}
