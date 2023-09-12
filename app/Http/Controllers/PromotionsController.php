<?php

namespace App\Http\Controllers;

use App\Models\Promotions;
use Illuminate\Http\Request;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.promotions.index');
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
     * @param  \App\Models\Promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function show(Promotions $promotions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotions $promotions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotions $promotions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotions $promotions)
    {
        //
    }
}
