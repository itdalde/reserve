<?php

namespace App\Http\Controllers;

use App\Interfaces\ServiceInterface;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\OccasionEventPrice;
use App\Models\OccasionType;
use App\Models\PlanType;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceTypes = ServiceType::all()->toArray();
        $services = OccasionEvent::where('id','<>',0)->get();
        $occasionTypes =  Occasion::all()->toArray();
        $plan = PlanType::all()->toArray();
        return view('admin.services.index',compact('occasionTypes','serviceTypes','plan','services' ));
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
        $data = $request->all();
        $company = $request->user()->company;
        $service = new OccasionEvent();
        $service->occasion_id = $data['occasion_type'];
        $service->name = $data['service_name'];
        $service->price = $data['service_price'];
        $service->description = $data['service_description'];
        $service->address_1 = $data['location'];
        $service->max_capacity = $data['hall_min_capacity'];
        $service->min_capacity = $data['hall_max_capacity'];
        $service->availability_start_date = $data['start_available_date'];
        $service->availability_end_date = $data['end_available_date'];
        $service->availability_time_in = $data['start_available_time'];
        $service->availability_time_out = $data['end_available_time'];
        $service->active = 1;
        if($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path("images/company/{$company->id}/services"), $imageName);
            $filename = "images/company/{$company->id}/services/{$imageName}";
            $service->image = $filename;
        }
        $service->service_type = $data['service_type'];
        $service->save();
        $price = new OccasionEventPrice();
        $price->occasion_event_id = $service->id;
        $price->plan_id = $data['plan_id'];
        $price->service_price= $data['service_price'];
        $price->package= $data['package_name'];
        $price->min_capacity= $data['package_min_capacity'];
        $price->max_capacity= $data['package_max_capacity'];
        $price->package_details= $data['package_details'];
        $price->package_price= $data['package_price'];
        $price->active = 1;

        return redirect()->back()->with('success', 'Service Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
