<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\OccasionType;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\PlanType;
use App\Models\ServiceType;
use Arcanedev\LogViewer\Entities\Log;
use Arcanedev\LogViewer\Entities\LogEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        $users = User::doesntHave('company')->with('roles')->sortable(['email' => 'asc'])->get();
        if(Auth::user()->hasRole('superadmin')) {
            return view('superadmin.dashboard',compact('users'));
        }
        $occasionTypes =  Occasion::all()->toArray();
        $plan = PlanType::all()->toArray();;
        if(!Auth::user()->company) {
            return redirect()->route('logout');
        }
        $services =  OccasionEvent::where('company_id',Auth::user()->company->id)->get();
        $serviceIds = $services ?  $services->pluck('id'): [];
        $orders = OrderItems::whereIn('service_id',$serviceIds)->get();
        $orderIds = $orders ? $orders->pluck('order_id'): [];
        $orders = Order::whereIn('id',$orderIds)->get();
        $userIds = $orders ? $orders->pluck('user_id'): [];
        $users = User::whereIn('id',$userIds)->sortable(['email' => 'asc'])->offset(0)->limit(10)->get();
        $orders = OrderItems::whereIn('service_id',$serviceIds)
            ->whereDate('created_at','>=', Carbon::today())
            ->with('service','service.price','service.price.planType','order','order.paymentMethod','order.user')->get()->toArray();

        return view('admin.dashboard',compact('orders','occasionTypes','plan','users','services' ));
    }


    public function getLogChartData(Request $request)
    {
        \Validator::make($request->all(), [
            'start' => 'required|date|before_or_equal:now',
            'end' => 'required|date|after_or_equal:start',
        ])->validate();

        $start = new Carbon($request->get('start'));
        $end = new Carbon($request->get('end'));

        $dates = collect(\LogViewer::dates())->filter(function ($value, $key) use ($start, $end) {
            $value = new Carbon($value);
            return $value->timestamp >= $start->timestamp && $value->timestamp <= $end->timestamp;
        });


        $levels = \LogViewer::levels();

        $data = [];

        while ($start->diffInDays($end, false) >= 0) {

            foreach ($levels as $level) {
                $data[$level][$start->format('Y-m-d')] = 0;
            }

            if ($dates->contains($start->format('Y-m-d'))) {
                /** @var  $log Log */
                $logs = \LogViewer::get($start->format('Y-m-d'));

                /** @var  $log LogEntry */
                foreach ($logs->entries() as $log) {
                    $data[$log->level][$log->datetime->format($start->format('Y-m-d'))] += 1;
                }
            }

            $start->addDay();
        }

        return response($data);
    }

    public function getRegistrationChartData()
    {

        $data = [
            'registration_form' => User::whereDoesntHave('providers')->count(),
            'google' => User::whereHas('providers', function ($query) {
                $query->where('provider', 'google');
            })->count(),
            'facebook' => User::whereHas('providers', function ($query) {
                $query->where('provider', 'facebook');
            })->count(),
            'twitter' => User::whereHas('providers', function ($query) {
                $query->where('provider', 'twitter');
            })->count(),
        ];

        return response($data);
    }
}
