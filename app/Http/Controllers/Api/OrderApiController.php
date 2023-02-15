<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderSplit;
use App\Models\PaymentDetails;
use Carbon\Carbon;

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
        $order = Order::with('items', 'paymentMethod', 'splitOrder')->where('reference_no', $request->reference_no)->first();

        $order['total_paid'] = OrderSplit::where('order_id', $order->id)->where('status', 'paid')->sum('amount');
        $order['balance'] = OrderSplit::where('order_id', $order->id)->where('status', 'pending')->sum('amount');

        return sendResponse($order, 'Your order with reference no. ' . $request->reference_no);
    }

    public function getUserOrders(Request $request) {
        $orders = Order::with('items', 'splitOrder')->where('user_id', $request->user_id)->get();
        foreach($orders as $order)
        {
            $os = OrderSplit::where('order_id', $order->id)->get();
            $order['total_paid'] = $os->where('status', 'paid')->sum('amount');
            $order['balance'] = $os->where('status', 'pending')->sum('amount');
            
            $osPending = $os->where('status', 'pending')->first();
            $osPaid = $os->where('status', 'paid')->first();
            $reference_no = $osPending ? $osPending->reference_no : $osPaid->reference_no;

            $order['payment_details'] = PaymentDetails::where('reference_no', $reference_no)->orderBy('created_at', 'desc')->first();
        }
        return sendResponse($orders, 'Orders under user ' . $request->user_id);
    }

    public function getPaymentDetailByReferenceNo(Request $request)
    {
        $os = OrderSplit::with('paymentDetail')->where('reference_order', $request->reference_no)->where('status', 'pending')->first();
        return sendResponse($os, 'Payment details by ref ' . $request->reference_no);
    }

    public function executeCommand(Request $request)
    {
        return sendResponse('For Command', 'For Command');   
    }
}
