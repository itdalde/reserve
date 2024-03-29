<?php

namespace App\Http\Controllers;

use App\Helpers\Common\GeneralHelper;
use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Models\EventImages;
use App\Models\Occasion;
use App\Models\OccasionEvent;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderSplit;
use App\Models\ServiceType;
use App\Models\Status;
use App\Utility\NotificationUtility;
use Carbon\Carbon;
use Google\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\VarDumper\VarDumper;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.settings.index');
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

    public function updateStatusOrder(Request $request) {
        $data = $request->all();
        $status = 'pending';
        $timeline = 'processing';
        switch ($data['action']){
            case 'accept':
                $status = 'processing';
                $timeline = 'processing';
                break;
            case 'decline':
                $status = 'declined';
                $timeline = 'order-declined';
                break;
            case 'complete':
                $status = 'completed';
                $timeline = 'order-completed';
                break;
            case 'cancel':
                $status = 'cancelled';
                $timeline = 'order-cancelled';
        }
        if(is_array($data['id'])) {
            foreach ($data['id'] as $id) {
                $item = OrderItems::where('id',$id)->first();
                $item->status = $status;
                $item->reason = isset($data['reason']) ? $data['reason'] : '';
                $item->timeline = $timeline;
                $item->save();

                $order = Order::where('id',$item->order_id)->first();
                $user = User::where('id', $order->user_id)->first();
                $locale = $user->app_language ?? 'en';
                Http::timeout(10)
                    ->withOptions(['verify' => false])
                    ->post('http://reservegcc.com:3000/reservation', [
                        'transaction' => $item->toArray(),
                        'status' => $status
                    ]);

                $trans = GeneralHelper::getNotification($locale, $status);
                $response = [
                    "type" => "order-update",
                    "title" => $trans['title'],
                    "status" => "success",
                    "message" => $trans['message'],
                    "data" => [$item->toArray() ]
                ];
                if($order) {
                    $fcmTokens = User::whereNotNull('fcm_token')->where('id',$order->user_id)->where('enable_notification',1)->pluck('fcm_token')->toArray();
                    NotificationUtility::sendNotification($trans['title'], $trans['message'], $fcmTokens, $response);
                }
            }
            $order = Order::where('id',$item->order_id)->first();
            $order->status = $status;
            $order->timeline = $timeline;
            $order->reason = isset($data['reason']) ? $data['reason'] : '';
            $order->save();
        } else {
            if(isset($data['is_order'])) {
                $orders = OrderItems::where('order_id',$data['id'])->get();
                foreach ($orders as $item) {
                    $item->status = $status;
                    $item->reason = isset($data['reason']) ? $data['reason'] : '';
                    $item->timeline = $timeline;
                    $item->save();

                    $order = Order::where('id',$item->order_id)->first();
                    $user = User::where('id', $order->user_id)->first();
                    $locale = $user->app_language ?? 'en';
                    Http::timeout(10)
                        ->withOptions(['verify' => false])
                        ->post('http://reservegcc.com:3000/reservation', [
                            'transaction' => $item->toArray(),
                            'status' => $status
                        ]);

                    $trans = GeneralHelper::getNotification($locale, $status);
                    $response = [
                        "type" => "order-update",
                        "title" => $trans['title'],
                        "status" => "success",
                        "message" => $trans['message'],
                        "data" => [$item->toArray() ]
                    ];
                    if($order) {
                        $fcmTokens = User::whereNotNull('fcm_token')->where('id',$order->user_id)->where('enable_notification',1)->pluck('fcm_token')->toArray();
                        NotificationUtility::sendNotification($trans['title'], $trans['message'], $fcmTokens, $response);
                    }
                }
                $order = Order::where('id',$item->order_id)->first();
                $order->status = $status;
                $order->timeline = $timeline;
                $order->reason = isset($data['reason']) ? $data['reason'] : '';
                $order->save();
            } else {
                $item = OrderItems::where('id',$data['id'])->first();
                $item->status = $status;
                $item->reason = isset($data['reason']) ? $data['reason'] : '';
                $item->timeline = $timeline;
                $item->save();

                $totalItem = OrderItems::where('order_id',$item->order_id)->count();
                $itemsAccepted = OrderItems::where('order_id',$item->order_id)->where('status',$status)->count();
                $order = Order::where('id',$item->order_id)->first();
                $user = User::where('id', $order->user_id)->first();
                $locale = $user->app_language ?? 'en';
                if($totalItem == $itemsAccepted) {
                    $order->status = $status;
                    $order->timeline = $timeline;
                    $order->reason = isset($data['reason']) ? $data['reason'] : '';
                    $order->save();
                }
                Http::timeout(10)
                    ->withOptions(['verify' => false])
                    ->post('http://reservegcc.com:3000/reservation', [
                        'transaction' => $item->toArray(),
                        'status' => $status
                    ]);
                $trans = GeneralHelper::getNotification($locale, $status);
                $response = [
                    "type" => "order-update",
                    "title" => $trans['title'],
                    "status" => "success",
                    "message" => $trans['message'],
                    "data" => [$item->toArray() ]
                ];
                if($order) {
                    $fcmTokens = User::whereNotNull('fcm_token')->where('id',$order->user_id)->where('enable_notification',1)->pluck('fcm_token')->toArray();
                    NotificationUtility::sendNotification($trans['title'], $trans['message'], $fcmTokens, $response);
                }
            }
        }

        if($request->ajax()){
            return json_encode($item);
        }
        return redirect::back()->with(['signup' => 'success' ,'order_item' => $item]);
    }

    public function manageOrders(Request $request)
    {
        $orders = [];
        try {
            $services = OccasionEvent::where('company_id',auth()->user()->company->id)->get()->pluck( 'id')->toArray();
            $orders = OrderItems::whereIn('service_id',$services)
                ->whereDate('created_at', Carbon::today())
                ->with('service','service.price','service.price.planType','order','order.paymentMethod','order.user')->get()->toArray();
            foreach ($orders as $k => $order) {
                $orders[$k]['balance'] = OrderSplit::where('order_id', $order['order']['id'])->where('status', 'pending')->sum('amount');
                $orders[$k]['total_paid'] = OrderSplit::where('order_id', $order['order']['id'])->where('status', 'paid')->sum('amount');
            }
        } catch (Exception $exception) {

        }
        return view('admin.orders.manage',compact('orders'));
    }

    public function services(Request $request)
    {
        $services = ServiceType::all();
        return view('admin.settings.services', compact('services'));
    }

    public function occasions(Request $request)
    {
        $occasions = Occasion::all();
        $services = OccasionEvent::with('company')->get()->toArray();
        return view('admin.settings.occasions', compact('occasions','services'));
    }

    public function statuses(Request $request)
    {
        $statuses = Status::all();
        return view('admin.settings.statuses', compact('statuses'));
    }

    public function roles(Request $request)
    {
        $roles = Role::all();
        return view('admin.settings.roles', compact('roles'));
    }

    public function companyUpdate(Request $request)
    {
        try {
            $data = $request->all();
            $hourPattern = '/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/';
            if (!preg_match($hourPattern, $data['open_at']) || !preg_match($hourPattern, $data['close_at'])) {
                return redirect()->back()->with('error', 'Business hours invalid format. Valid format should be (08:00) - (21:00)');
            }
            $user = auth()->user();
            $company = $user->company;
            if ($request->file('company_image')) {
                $file = $request->file('company_image');
                $imageName = time() . '.' . $file->extension();
                $file->move(public_path("assets/images/company"), $imageName);
                $filename = "assets/images/company/{$imageName}";
                $company->logo = $filename;
            }
            $company->description = $data['description'];
            $company->location = $data['location'] ?? '';
            $company->tags = $data['tags'] ?? '';
            $company->phone_number = $data['phone_number'];
            $company->name = $data['name'];
            $company->business_days = $data['availability'];
            $company->open_at = $data['open_at'];
            $company->close_at = $data['close_at'];
            $company->is_custom = isset($data['is_custom']) ? 1 : 0;
            $company->save();
            $message = GeneralHelper::getConcatTranslation($user->app_language ?? 'en', 'company', 'action.updated', 'success');
            return redirect()->back()->with('success', $message);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function statusDelete(Request $request)
    {
        try {
            $data = $request->all();
            Status::where('id',$data['id'])->delete();
            $locale = $request->getLocale();
            $message = GeneralHelper::getConcatTranslation($locale, 'company', 'action.updated', 'success');
            Status::where('id',$data['id'])->delete();
            return redirect()->back()->with('success', $message);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function statusUpdate(Request $request)
    {
        try {
            $data = $request->all();
            $status = Status::where('id',$data['id'])->first();
            $status->name = $data['name'];
            $status->active = isset($data['active']) ? 1 : 0;
            $status->save();
            $locale = $request->getLocale();
            $message = GeneralHelper::getConcatTranslation($locale, 'company', 'action.updated', 'success');
            return redirect()->back()->with('success', $message);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function statusStore(Request $request)
    {
        try {
            $data = $request->all();
            $status = new Status();
            $status->name = $data['name'];
            $status->active = isset($data['active']) ? 1 : 0;
            $status->save();
            $locale = $request->getLocale();
            $message = GeneralHelper::getConcatTranslation($locale, 'company', 'action.updated', 'success');
            return redirect()->back()->with('success', $message);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function serviceDelete(Request $request)
    {
        try {
            $data = $request->all();
            ServiceType::where('id',$data['id'])->delete();
            $locale = $request->getLocale();
            $message = GeneralHelper::getConcatTranslation($locale, 'service.type', 'action.deleted', 'success');
            return redirect()->back()->with('success', $message);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function serviceUpdate(Request $request)
    {
        try {
            $data = $request->all();
            $status = ServiceType::where('id',$data['id'])->first();
            $status->name = $data['name'];
            $status->active = isset($data['active']) ? 1 : 0;
            $status->save();
            $locale = $request->getLocale();
            $message = GeneralHelper::getConcatTranslation($locale, 'service.type', 'action.updated', 'success');
            return redirect()->back()->with('success', $message);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function serviceStore(Request $request)
    {
        try {
            $data = $request->all();
            $status = new ServiceType();
            $status->name = $data['name'];
            $status->active = isset($data['active']) ? 1 : 0;
            $status->save();
            $locale = $request->getLocale();
            $message = GeneralHelper::getConcatTranslation($locale, 'service.type', 'action.created', 'success');
            return redirect()->back()->with('success', $message);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $user = auth()->user();
            $user->first_name = $data['first_name'];
            if ($request->file('profile_image')) {
                $file = $request->file('profile_image');
                $imageName = time() . '.' . $file->extension();
                $file->move(public_path("assets/images/avatar"), $imageName);
                $filename = "assets/images/avatar/{$imageName}";
                $user->profile_picture = $filename;
            }
            $user->last_name = $data['last_name'];
            $user->location = $data['location'] ?? '';
            $user->phone_number = $data['phone_number'];
            if ($data['password'] != '') {
                $user->password = bcrypt($data['password']);
            }
            $user->save();
            $lang = $user->app_language ? $user->app_language : 'en';
            $message = GeneralHelper::getConcatTranslation($lang, 'user', 'action.updated', 'success');
            return redirect()->back()->with('success', $message);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
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
