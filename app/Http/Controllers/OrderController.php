<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderInterface;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\OccasionType;
use App\Models\OrderItems;
use App\Models\PlanType;
use App\Models\ServiceType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceTypes = ServiceType::all()->toArray();
        $occasionTypes =  Occasion::all()->toArray();
        $plan = PlanType::all()->toArray();
        $services = OccasionEvent::where('company_id',auth()->user()->company->id)->get()->pluck( 'id')->toArray();
        $futureOrders = OrderItems::whereIn('service_id',$services)
            ->whereDate('created_at','>', Carbon::today())
            ->with('service','service.price','service.price.planType','order','order.paymentMethod','order.user')->get()->toArray();

        $orders = OrderItems::whereIn('service_id',$services)
            ->whereDate('created_at', Carbon::today())
            ->with('service','service.price','service.price.planType','order','order.paymentMethod','order.user')->get()->toArray();
//       dd($orders);
        return view('admin.orders.index',compact('occasionTypes','serviceTypes' ,'plan','orders','futureOrders' ));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
