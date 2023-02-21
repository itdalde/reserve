<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Models\Order;
use App\Models\OrderSplit;
use App\Utility\NotificationUtility;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationApiController extends Controller
{
    //
    public function checkOrderCompleted(Request $request)
    {
        $orders = Order::with('items', 'splitOrder')->where('orders.created_at', '>=', Carbon::now()->addDays(7)->toDateTimeString())->get();
        foreach($orders as $order)
        {
            $balance = OrderSplit::where('order_id', $order->id)->where('status', 'pending')->sum('amount');

            foreach($order->items as $item)
            {
                if ($balance == 0 && Carbon::now()->subDay()->toDateTimeString() > $item->schedule_end_datetime) {
                    $item->status = 'completed';
                    $item->timeline = 'order-completed';
                    $item->save();

                    $order['status'] = 'completed';
                    $order['timeline'] = 'order-completed';
                    $order->save();
                }
            }

        }

        return sendResponse('Notification Invoke', 'Notification Invoke');
    }

    public function paidOrders(Request $request)
    {
        $orders = Order::where('status', 'pending')->where('updated_at', '>=', Carbon::now()->addDay()->toDateTimeString())->get();
        foreach($orders as $order) {
            $response = [
                "status" => "success",
                "message" => "Notification invoke for pending orders",
                "data" => ['order' => $order ]
            ];
            $fcmTokens = User::where('user_id', $order->user_id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
            NotificationUtility::sendNotification('Pending Order', 'You still have pending order in your cart.', $fcmTokens, $response);
        } 
        return sendResponse('Order completed', 'Orders Completed');
    }

    public function invokeNotificationByUser(Request $request)
    {
        $fcmTokens = User::where('user_id', $request->user_id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        $order = Order::where('user_id', $request->user_id)->where('status', 'pending')->get();
        $response = [
            "status" => "success",
            "message" => "Notification invoke for pending orders",
            "data" => ['order' => $order ]
        ];
        NotificationUtility::sendNotification('Pending Order', 'You still have pending order in your cart.', $fcmTokens, $response);

        return sendResponse('Notificatin Invoke', 'User order pending');
    }
}