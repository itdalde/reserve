<?php

namespace App\Http\Controllers;

use App\Models\Promotions;
use Illuminate\Http\Request;
use Carbon\Carbon;
class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = Promotions::where('company_id', auth()->user()->company->id)->get();
        return view('admin.promotions.index', compact('promotions'));
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
        $data = $request->all();
        $promotion = new Promotions();
        $promotion->name = $data['name'];
        $promotion->code = $data['code'];
        $promotion->description = $data['description'];
        $promotion->price = $data['price'];
        $promotion->percent = $data['percent'];
        $promotion->qty = $data['quantity'];
        $promotion->single_use = isset($data['single_use']) && $data['single_use'] ? 1 : 0;
        $promotion->start_date = $data['start_date'];
        $promotion->end_date = $data['end_date'];
        $promotion->status = 0;
        $promotion->company_id = auth()->user()->company->id;
        $promotion->save();

        $promotions = Promotions::where('company_id', auth()->user()->company->id)->get();
        return view('admin.promotions.index', compact('promotions'));
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
    public function destroy(Promotions $promotion)
    {
        //
        Promotions::destroy($promotion->id);
        $promotions = Promotions::where('company_id', auth()->user()->company->id)->get();
        return view('admin.promotions.index', compact('promotions'));
    }
}
