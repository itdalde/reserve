<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Common\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Models\AvailableDates;
use App\Models\Cart;
use App\Models\CartAdOns;
use App\Models\CartItem;
use App\Models\OccasionEvent;
use App\Models\Order;
use App\Models\OrderAdOns;
use App\Models\OrderItems;
use App\Models\OrderSplit;
use App\Models\PaymentDetails;
use App\Utility\NotificationUtility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CartApiController extends Controller
{
    //


    public function addServiceToCart(Request $request)
    {
        $data = $request->cart;
        $userCart = Cart::where('user_id', $request->user_id)->where('active', 1)->first();
        $cart = isset($userCart) ? $userCart : new Cart();


        $cart->total_amount = (int)$cart->total_amount + $data['total_amount'];
        $cart->user_id = $request->user_id;
        $cart->save();

        foreach ($data['items'] as $item) {
            $isStartAvailable = AvailableDates::where('service_id', $item['service_id'])
                ->whereDate('date_obj', '=', date('Y-m-d', strtotime($item['schedule_start_datetime'])))->first();
            $isEndAvailable = AvailableDates::where('service_id', $item['service_id'])
                ->whereDate('date_obj', '=', date('Y-m-d', strtotime($item['schedule_end_datetime'])))->first();
            if ($isStartAvailable) {
                return sendError('The schedule_start_datetime is not available', 'Unable on adding to card');
            }
            if ($isEndAvailable) {
                return sendError('The schedule_end_datetime is not available', 'Unable on adding to card');
            }
        }

        foreach ($data['items'] as $item) {
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->service_id = $item['service_id'];
            $cartItem->schedule_start_datetime = $item['schedule_start_datetime'];
            $cartItem->schedule_end_datetime = $item['schedule_end_datetime'];
            $cartItem->guests = $item['guests'];
            $cartItem->is_custom = isset($item['is_custom']) ?? 0;
            $cartItem->save();
            if($item['ad_on_ids']) {
                foreach($item['ad_on_ids'] as $adOn) {
                    $cartAdOn = new CartAdOns();
                    $cartAdOn->service_id = $item['service_id'];
                    $cartAdOn->cart_id = $cart->id;
                    $cartAdOn->cart_item_id = $cartItem->id;
                    $cartAdOn->add_on_id = $adOn;
                    $cartAdOn->save();
                }
            }
        }


        $cart->total_items = CartItem::where('cart_id', $cart->id)->count();
        $cart->save();

        return sendResponse(['cart_id' => $cart->id], 'Successfully added to cart.');
    }

    public function getUserCart(Request $request)
    {
        $userCart = Cart::with(['items' => function ($query) {
            $query->select(
                'id',
                'cart_id',
                'service_id',
                'schedule_start_datetime',
                'schedule_end_datetime',
                'guests',
                'status'
            );
        }])->join('cart_items', 'cart.id', '=', 'cart_items.cart_id')
            ->join('services', 'cart_items.service_id', '=', 'services.id')
            ->where('services.active', 1)
            ->where('cart.user_id', $request->user_id)
            ->where('cart.active', 1)
            ->get([
                'cart.id',
                'cart.total_items',
                'cart.total_amount',
                'cart.user_id'
            ]);
        return sendResponse($userCart, 'Get users cart');
    }

    public function getUserOrders(Request $request)
    {

        $orders = Order::with('items','items.adOns', 'adOns', 'paymentMethod', 'paymentDetails')
            ->where('user_id', $request->user_id)->get();
        return sendResponse($orders, 'User orders');
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
        return sendResponse($cartItem, 'Cart items where status ' . $request->status);
    }

    public function getServiceByCartAndServiceId(Request $request)
    {
        $cartItem = CartItem::with('service')
            ->where('cart_id', $request->cart_id)
            ->where('service_id', $request->service_id)
            ->first();
        return sendResponse($cartItem, 'Cart items where service ' . $request->service_id);
    }

    public function placeOrder(Request $request)
    {
        $data = $request->order;

        $cart = Cart::where('id', $request->cart_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($cart == null) {
            return sendError('There is no item in your cart', 'Unable to place an order');
        }

        foreach ($data['items'] as $k => $item) {
            $event = OccasionEvent::where('id', $item['service_id'])->first();
            if (!$event) {
                unset($data['items'][$k]);
            }
            if ($event->active == 0) {
                unset($data['items'][$k]);
            }
            if ($event->active == 2) {
                unset($data['items'][$k]);
            }
            if ($event->active == 3) {
                unset($data['items'][$k]);
            }

            $cartItem = CartItem::where('cart_id', $request->cart_id)
                ->where('service_id', $item['service_id'])->where('status', 'active')->first();
            $isStartAvailable = AvailableDates::where('service_id', $item['service_id'])
                ->whereDate('date_obj', '=', date('Y-m-d', strtotime($cartItem->schedule_start_datetime)))->first();
            $isEndAvailable = AvailableDates::where('service_id', $item['service_id'])
                ->whereDate('date_obj', '=', date('Y-m-d', strtotime($cartItem->schedule_end_datetime)))->first();
            if ($isStartAvailable) {
                return sendError('The schedule_start_datetime is not available', 'Unable to place an order');
            }
            if ($isEndAvailable) {
                return sendError('The schedule_end_datetime is not available', 'Unable to place an order');
            }
        }
        if (count($data['items']) == 0) {
            return sendError('Items are inactive', 'Unable to place an order');
        }
        $order = new Order();
        $order->cart_id = $request->cart_id;
        $order->user_id = $request->user_id;
        $order->reference_no = GeneralHelper::referenceNo();
        $order->total_items = $cart->total_items;
        $order->total_amount = $cart->total_amount;
        $order->payment_method = $data['payment_method'];
        $order->contact_details = $data['contact_details'];
        $order->location = $data['location'];
        $order->promo_code = $data['promo_code'];
        $order->agent = $data['agent'];
        $order->notes = $data['notes'];
        $order->save();
        foreach ($data['items'] as $item) {

            $serviceTotalOrder = OrderItems::where('service_id', $item['service_id'])
                ->where('created_at', '<>', Carbon::today()->toDateString())
                ->count();

            $event = OccasionEvent::where('id', $item['service_id'])
                ->first();

            if ($event && $event->active) {
                $cartItem = CartItem::where('cart_id', $request->cart_id)
                    ->where('service_id', $item['service_id'])->where('status', 'active')->first();

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

                $cartItemAdOn = CartAdOns::where('cart_id', $cartItem->id)->first();
                if($cartItemAdOn) {
                    $orderAdOn = new OrderAdOns();
                    $orderAdOn->service_id = $item['service_id'];
                    $orderAdOn->order_id = $order->id;
                    $orderAdOn->order_item_id = $cartItem->id;
                    $orderAdOn->add_on_id = $cartItemAdOn->add_on_id;
                    $orderAdOn->save();
                }
            }
        }

        $cart->active = 0;
        $cart->save();

        for ($i = 0; $i < 2; $i++) {
            $orderSplit = new OrderSplit();
            $orderSplit->order_id = $order->id;
            $orderSplit->reference_order = $order->reference_no;
            $orderSplit->reference_no = GeneralHelper::referenceNo();
            $orderSplit->amount = $order->total_amount / 2;
            $orderSplit->status = 'pending';
            $orderSplit->save();
        }
        return sendResponse(['reference_no' => $order->reference_no], 'Order has been placed successfully!');
    }
}
