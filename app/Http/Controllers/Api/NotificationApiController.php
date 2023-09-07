<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Common\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderSplit;
use App\Utility\NotificationUtility;
use Carbon\Carbon;
use Google\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NotificationApiController extends Controller
{
    //
    public function checkOrderCompleted(Request $request)
    {
        try {
            $orders = Order::with('items', 'splitOrder')->where('orders.created_at', '>=', Carbon::now()->addDays(7)->toDateTimeString())->get();
            foreach ($orders as $order) {
                $balance = OrderSplit::where('order_id', $order->id)->where('status', 'pending')->sum('amount');

                foreach ($order->items as $item) {
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
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function paidOrders(Request $request)
    {
        try {
            $orders = Order::where('status', 'pending')->where('updated_at', '>=', Carbon::now()->addDay()->toDateTimeString())->get();
            foreach ($orders as $order) {
                $response = [
                    "status" => "success",
                    "message" => "Notification invoke for pending orders",
                    "data" => ['order' => $order]
                ];
                $fcmTokens = User::where('id', $order->user_id)->where('enable_notification', 1)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                NotificationUtility::sendNotification('Pending Order', 'You still have pending order in your cart.', $fcmTokens, $response);
            }
            return sendResponse('Order completed', 'Orders Completed');
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function invokeNotificationByUser(Request $request)
    {
        try {
            $fcmTokens = User::where('id', $request->user_id)->where('enable_notification', 1)->whereNotNull('fcm_token')->where('enable_notification', 1)->pluck('fcm_token')->toArray();
            $order = Order::where('user_id', $request->user_id)->where('status', 'pending')->get();
            $response = [
                "status" => "success",
                "message" => "Notification invoke for pending orders",
                "data" => ['order' => $order]
            ];

            NotificationUtility::sendNotification('Pending Order', 'You still have pending order in your cart.', $fcmTokens, $response);

            return sendResponse('Notificatin Invoke', 'User order pending');
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function getTranslation(Request $request)
    {
        try {
            $translation = GeneralHelper::getTranslation($request->locale, $request->key);
            return sendResponse($translation, 'Translated response');
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function getCurrentLanguage(Request $request)
    {
        try {
            $lang = $request['lang'];
            $user = User::where('id', $request['user_id'])->first();
            return sendResponse($user->app_language == $lang, 'Current locale-' . $user->app_language);
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function getNotificationByUserID(Request $request, $user_id): JsonResponse
    {
        try {
            $notifications = Notification::where('user_id', $user_id)->get();
            return sendResponse($notifications, 'Fetched Notification');
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function enableNotification(Request $request, $user_id): JsonResponse
    {
        try {
            $user = User::where('id', $user_id)->first();
            $user->enable_notification = (int)$request->enable_notification;
            $user->save();
            return sendResponse($user, 'Updated Notification');
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

}
