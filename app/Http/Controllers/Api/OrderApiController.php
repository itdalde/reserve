<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;

class OrderApiController extends Controller
{
    //

    public function placeOrder(Request $request)
    {
        $data = $request->order;
        $order = new Order();
        $order->cart_id = $request->cart_id;
        $order->payment_method = $data['payment_method'];
        $order->contact_details = $data['contact_details'];
        $order->location = $data['location'];
        $order->agent = $data['agent'];
        $order->notes = $data['notes'];
        $order->status = 'pending';
        $order->save();

        $cart = Cart::where('user_id', $request->user_id)
        ->where('status', 'active')
        ->first();
        $cart->status = 'placed';
        $cart->save();

        return sendResponse('save', 'save order');
    }

    public function getOrder(Request $request)
    {
        $order = Order::where('cart_id', $request->cart_id,)
        ->where('status', 'pending')->first();

        return sendResponse($order, 'save order');
    }
}
