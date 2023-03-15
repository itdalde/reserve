<?php

namespace App\Http\Controllers;

use App\Helpers\Common\GeneralHelper;
use App\Interfaces\OrderInterface;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\OccasionType;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderSplit;
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

        $orders = OrderItems::whereIn('service_id',$services)
            ->with('service','service.price','service.price.planType','order','order.paymentMethod','order.user', 'order.splitOrder')->get()->toArray();
        foreach ($orders as $k => $order) {
            $orders[$k]['balance'] = OrderSplit::where('order_id', $order['order']['id'])->where('status', 'pending')->sum('amount');
            $orders[$k]['total_paid'] = OrderSplit::where('order_id', $order['order']['id'])->where('status', 'paid')->sum('amount');
        }
        return view('admin.orders.index',compact('occasionTypes','serviceTypes' ,'plan','orders' ));
    }
    public function superList() {
        $orders = Order::with('paymentMethod','user')->get()->toArray();
        return view('superadmin.orders',compact('orders'));
    }
    public function superListView(Request $request) {
        $id = $request['id'];
        $order = Order::where('id',$id)->with('user','items','paymentMethod','paymentDetails', 'splitOrder')->first()->toArray();
        $order['total_paid'] = OrderSplit::where('order_id', $order['id'])->where('status', 'paid')->sum('amount');
        $order['balance'] = OrderSplit::where('order_id', $order['id'])->where('status', 'pending')->sum('amount');
        return view('superadmin.orders.view',compact('order'));
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
        $order = Order::where('id',$id)->with('user','items','paymentMethod','paymentDetails', 'splitOrder')->first()->toArray();
        $order['total_paid'] = OrderSplit::where('order_id', $order['id'])->where('status', 'paid')->sum('amount');
        $order['balance'] = OrderSplit::where('order_id', $order['id'])->where('status', 'pending')->sum('amount');

        return view('admin.orders.view',compact('order'));
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
