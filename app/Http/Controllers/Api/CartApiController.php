<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    //

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
            'user_id',
            'status'
        ]);
        $totalAmount = 0;
        foreach($userCart as $cart)
        {
            $cart->total_items = $cart->items->count();
            foreach($cart->items as $items)
            {
                $totalAmount += $items->service->price;
            }
            $cart->total_amount = $totalAmount;
        }


        return sendResponse($userCart, 'Get users cart');
    }

    public function saveUserCart(Request $request)
    {
        $data = $request->cart;
        $cart = new Cart();
        $cart->total_items = $data['total_items'];
        $cart->total_amount = $data['total_amount'];
        $cart->promo_code = $data['promo_code'];
        $cart->user_id = $data['user_id'];
        $cart->save();

        foreach($data['items'] as $tmpItem) {
            $item = new CartItem();
            $item->cart_id = $cart->id;
            $item->service_id = $tmpItem['service_id'];
            $item->schedule_start_datetime = $tmpItem['schedule_start_datetime'];
            $item->schedule_end_datetime = $tmpItem['schedule_end_datetime'];
            $item->guests = $tmpItem['guests'];
            $item->save();
        }

        return sendResponse("Saved Successfully", 'Save user cart');
    }

    public function updateUserCart(Request $request)
    {
        $data = $request->cart;
        $activeCart = Cart::where('user_id', $request->user_id)
        ->where('status', 'active')
        ->first();

        $activeCart->total_items = $data['total_items'];
        $activeCart->total_amount = $data['total_amount'];
        $activeCart->promo_code = $data['promo_code'];
        $activeCart->user_id = $data['user_id'];

        foreach($data['items'] as $tmpItem) {
            $item = CartItem::where('cart_id', $data['cart_id'])
            ->where('service_id', $tmpItem['service_id'])
            ->first();
            $item->schedule_start_datetime = $tmpItem['schedule_start_datetime'];
            $item->schedule_end_datetime = $tmpItem['schedule_end_datetime'];
            $item->guests = $tmpItem['guests'];
            $item->save();
        }
        $activeCart->save();

        return sendResponse($activeCart, 'Update cart');
    }

    public function checkoutCart(Request $request)
    {
        $cart = Cart::where('user_id', $request->user_id)
        ->where('status', 'active')
        ->first();
        $cart->status = 'placed';
        $cart->save();
        return sendResponse("Order is placed", 'Checkout user cart');
    }

    public function removeItemFromCart(Request $request)
    {
        $item = CartItem::where('cart_id', $request->cart_id)
        ->where('service_id', $request->service_id)->first();
        $item->status = 0;
        $item->save();
        return sendResponse("Item is removed", 'Item removed');
    }
}
