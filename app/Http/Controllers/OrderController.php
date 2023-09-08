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
use Illuminate\Support\Facades\DB;
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

    public function orderAssignment() {

        $serviceTypes = ServiceType::all()->toArray();
        $occasionTypes =  Occasion::all()->toArray();
        return view('admin.order-assignment.index',
        compact('occasionTypes','serviceTypes'));
    }

    public function getAverageOrder() {
        $services = OccasionEvent::where('company_id',auth()->user()->company->id)->get()->pluck( 'id')->toArray();
        $data = OrderItems::select(DB::raw('count(service_id) as `data`'),DB::raw("DATE_FORMAT(schedule_start_datetime, '%m') month") )
            ->whereIn('service_id',$services)
            ->where('status','completed')
            ->whereYear('schedule_start_datetime', date('Y'))
            ->groupBy('month')->orderBy('month')->get()->toArray();
        $response = [
            'month' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];
        foreach ($data as $datum) {
            switch ($datum['month']) {
                case '01':
                    $response['data'][0] = $datum['data'];
                    break;
                case '02':
                    $response['data'][1] = $datum['data'];
                    break;
                case '03':
                    $response['data'][2] = $datum['data'];
                    break;
                case '04':
                    $response['data'][3] = $datum['data'];
                    break;
                case '05':
                    $response['data'][4] = $datum['data'];
                    break;
                case '06':
                    $response['data'][5] = $datum['data'];
                    break;
                case '07':
                    $response['data'][6] = $datum['data'];
                    break;
                case '08':
                    $response['data'][7] = $datum['data'];
                    break;
                case '09':
                    $response['data'][8] = $datum['data'];
                    break;
                case '10':
                    $response['data'][9] = $datum['data'];
                    break;
                case '11':
                    $response['data'][10] = $datum['data'];
                    break;
                case '12':
                    $response['data'][11] = $datum['data'];
                    break;
            }
        }

        $months = $response['month'];
        $values = $response['data'];

        $currentMonthIndex = date('n') - 1; // Get the index of the current month (0-11)
        $currentMonth = $months[$currentMonthIndex];
        $currentValue = $values[$currentMonthIndex];

        $previousMonthIndex = $currentMonthIndex - 1;
        if ($previousMonthIndex < 0) {
            $previousMonthIndex = 11; // Wrap around to December if current month is January
        }
        $previousMonth = $months[$previousMonthIndex];
        $previousValue = $values[$previousMonthIndex];

        if ($previousValue === 0 && $currentValue !== 0) {
            $percentageChange = "100";
        } elseif ($previousValue === 0 && $currentValue === 0) {
            $percentageChange = "0";
        } else {
            $changePercentage = (($currentValue - $previousValue) / abs($previousValue)) * 100;
            $percentageChange = number_format($changePercentage, 2) . "%";
        }
        $response['percentageChange'] = $percentageChange;
        return response()->json($response);
    }

    public function superList() {
        $orders = Order::with('paymentMethod','user','items')->get()->toArray();
        foreach ($orders as $k => $order) {
            if(empty($order['items'])) {
                unset($orders[$k]);
                continue;
            }
            $orders[$k]['balance'] = OrderSplit::where('order_id', $order['id'])->where('status', 'pending')->sum('amount');
            $orders[$k]['total_paid'] = OrderSplit::where('order_id', $order['id'])->where('status', 'paid')->sum('amount');
        }
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
    public function show($id,Request $reques)
    {
        $from = $reques->from;
        $order = Order::where('id',$id)->with('user','items','paymentMethod','paymentDetails', 'splitOrder')->first()->toArray();
        $order['total_paid'] = OrderSplit::where('order_id', $order['id'])->where('status', 'paid')->sum('amount');
        $order['balance'] = OrderSplit::where('order_id', $order['id'])->where('status', 'pending')->sum('amount');
        return view('admin.orders.view',compact('order','from'));
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
