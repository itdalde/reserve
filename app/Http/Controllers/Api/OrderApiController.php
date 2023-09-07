<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Common\GeneralHelper;
use App\Http\Controllers\Controller;
use Google\Exception;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderSplit;
use App\Models\PaymentDetails;

class OrderApiController extends Controller
{
    //

    public function updateTimelineForOrder(Request $request)
    {

        try {
            $order = Order::where('id', $request->order_id)->first();
            $order->timeline = $request->timeline;
            $order->save();
            return sendResponse($order, 'Your order timeline is ' . $request->timeline . '.');
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function updateStatusForOrder(Request $request)
    {
        try {
            $order = Order::where('id', $request->order_id)->first();
            $order->status = $request->status;
            $order->save();
            return sendResponse($order, 'Your order has been' . $request->status);
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function getOrderByReferenceNo(Request $request)
    {
        try {
            $order = Order::with('items', 'paymentMethod', 'splitOrder')->where('reference_no', $request->reference_no)->first();

            $order['total_paid'] = OrderSplit::where('order_id', $order->id)->where('status', 'paid')->sum('amount');
            $order['balance'] = OrderSplit::where('order_id', $order->id)->where('status', 'pending')->sum('amount');

            return sendResponse($order, 'Your order with reference no. ' . $request->reference_no);
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function getUserOrders(Request $request)
    {
        try {
            $orders = Order::with('items', 'splitOrder')->where('user_id', $request->user_id)->get();
            foreach ($orders as $order) {
                $order['total_paid'] = GeneralHelper::orderBalance($order->id, 'paid');
                $order['balance'] = GeneralHelper::orderBalance($order->id, 'pending');

                $osPending = OrderSplit::where('status', 'pending')->first();
                $order['payment_details'] = $osPending ? PaymentDetails::where('reference_no', $osPending->reference_no)->orderBy('created_at', 'desc')->first() : null;
            }
            return sendResponse($orders, 'Orders under user ' . $request->user_id);
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function getPaymentDetailByReferenceNo(Request $request)
    {
        try {
            $os = OrderSplit::with('paymentDetail')->where('reference_order', $request->reference_no)->where('status', 'pending')->first();
            return sendResponse($os, 'Payment details by ref ' . $request->reference_no);
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function executeCommand(Request $request)
    {
        try {
            return sendResponse('For Command', 'For Command');
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }
}
