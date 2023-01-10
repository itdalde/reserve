<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderApiController extends Controller
{
    //

    public function updateTimelineForOrder(Request $request) {

        $order = Order::where('id', $request->order_id)->first();
        $order->timeline = $request->timeline;
        $order->save();
        return sendResponse($order, 'Your order timeline is ' . $request->timeline .  '.');
    }

    public function updateStatusForOrder(Request $request) {
        $order = Order::where('id', $request->order_id)->first();
        $order->status = $request->status;
        $order->save();
        return sendResponse($order, 'Your order has been' . $request->status);
    }

    public function getOrderByReferenceNo(Request $request) {
        $order = Order::with('items', 'paymentMethod')->where('reference_no', $request->reference_no)->first();
        return sendResponse($order, 'Your order with reference no. ' . $request->reference_no);
    }

    public function getUserOrders(Request $request) {
        $orders = Order::with('items', 'paymentDetails')->where('user_id', $request->user_id)->get();
        return sendResponse($orders, 'Orders under user ' . $request->user_id);
    }
}
