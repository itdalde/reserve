<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
        $cart = $request;
        return sendResponse($cart, 'Save user cart');
    }

    public function updateUserCart(Request $request)
    {
        $cart = $request;
        return sendResponse($cart, 'Update cart');
    }
}
