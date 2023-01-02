<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OccasionEvent;
use App\Models\Order;
use App\Models\OrderItems;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    //



    public function addServiceToCart(Request $request)
    {
        $data = $request->cart;
        $userCart = Cart::where('user_id', $request->user_id)->first();
        $cart = isset($userCart) ? $userCart : new Cart();

        $cart->total_items = $data['total_items'];
        $cart->total_amount = $data['total_amount'];
        $cart->promo_code = $data['promo_code'];
        $cart->user_id = $request->user_id;
        $cart->save();

        foreach($data['items'] as $item)
        {
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->service_id = $item['service_id'];
            $cartItem->schedule_start_datetime = $item['schedule_start_datetime'];
            $cartItem->schedule_end_datetime = $item['schedule_end_datetime'];
            $cartItem->guests = $item['guests'];
            $cartItem->is_custom = isset($item['is_custom']) ?? 0;
            $cartItem->save();
        }
        return sendResponse('Successfully added to cart.', 'Save user cart');
    }

    public function getUserCart(Request $request)
    {
        $userCart = Cart::with(['items' => function($query) {
            $query->select(
                'id',
                'cart_id',
                'service_id',
                'schedule_start_datetime',
                'schedule_end_datetime',
                'guests',
                'status'
            );
        }])
        ->where('user_id', $request->user_id)
        ->get([
            'id',
            'total_items',
            'total_amount',
            'promo_code',
            'user_id'
        ]);
        return sendResponse($userCart, 'Get users cart');
    }

    public function removeServiceFromCart(Request $request)
    {
        CartItem::where('cart_id', $request->cart_id)
        ->where('service_id', $request->service_id)->delete();

        $cart = Cart::where('id', $request->cart_id)->first();

        $occasionEvent = OccasionEvent::where('id', $request->service_id)->first();

        $cart->total_items = $cart->total_items - 1;
        $cart->total_amount = $cart->total_amount - $occasionEvent->price;
        $cart->save();

        return sendResponse('Item successfully removed.', 'Item removed');
    }

    public function updateServiceFromCart(Request $request)
    {
        $data = $request->cart;
        $item = CartItem::where('cart_id', $request->cart_id)
        ->where('service_id', $request->service_id)
        ->first();
        $item->schedule_start_datetime = $data['items'][0]['schedule_start_datetime'];
        $item->schedule_end_datetime = $data['items'][0]['schedule_end_datetime'];
        $item->guests = $data['items'][0]['guests'];
        $item->save();
        return sendResponse('Service updated successfully.', 'Item updated');
    }

    public function getItemInCartByStatus(Request $request)
    {
        $cartItem = CartItem::with('service')
        ->where('cart_id', $request->cart_id)
        ->where('status', $request->status)
        ->get();
        return sendResponse($cartItem, 'Cart items where status '. $request->status);
    }

    public function getServiceByCartAndServiceId(Request $request) {
        $cartItem = CartItem::with('service')
        ->where('cart_id', $request->cart_id)
        ->where('service_id', $request->service_id)
        ->first();
        return sendResponse($cartItem, 'Cart items where service '. $request->service_id);
    }

    public function placeOrder(Request $request)
    {
        $data = $request->order;

        $cart = Cart::where('id', $request->cart_id)->first();
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->reference_no = str_pad(mt_rand(1, substr(time(), 1, -1)), 8, '0', STR_PAD_LEFT);
        $order->total_items = $cart->total_items;
        $order->total_amount = $cart->total_amount;
        $order->payment_method = $data['payment_method'];
        $order->contact_details = $data['contact_details'];
        $order->location = $data['location'];
        $order->promo_code = $data['promo_code'];
        $order->agent = $data['agent'];
        $order->notes = $data['notes'];
        $order->save();
        foreach($data['items'] as $item) {

            $serviceTotalOrder = OrderItems::where('service_id', $item['service_id'])
                ->where('created_at', '<>', Carbon::today()->toDateString())
                ->count();

            $event = OccasionEvent::where('id', $item['service_id'])
            ->first();

            $cartItem = CartItem::where('cart_id', $request->cart_id)
            ->where('service_id', $item['service_id'])->first();

            $orderItems = new OrderItems();
            $orderItems->order_id = $order->id;
            $orderItems->service_id = $item['service_id'];
            $orderItems->schedule_start_datetime = $cartItem->schedule_start_datetime;
            $orderItems->schedule_end_datetime = $cartItem->schedule_end_datetime;
            $orderItems->guests = $cartItem->guests;
            $orderItems->status = ($serviceTotalOrder + 1) > $event['availability_slot'] ? 'pending' : ((bool)$cartItem->is_custom ? 'pending' : 'accepted');
            $orderItems->is_custom = $cartItem->is_custom;
            $orderItems->save();

            $cartItem->status = 'ordered';
            $cartItem->save();
        }
        return sendResponse($order->reference_no, 'Successfully placed your order.');
    }
}
