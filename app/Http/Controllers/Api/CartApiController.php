<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
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
        $item = CartItem::where('cart_id', $request->cart_id)
        ->where('service_id', $request->service_id)->first();
        $item->status = 'cancelled';
        $item->save();
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

    public function checkoutCart(Request $request)
    {
        $cart = Cart::where('user_id', $request->user_id)
        ->where('status', 'active')
        ->first();
        $cart->status = 'placed';
        $cart->save();
        return sendResponse('Order is placed', 'Checkout user cart');
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
}
