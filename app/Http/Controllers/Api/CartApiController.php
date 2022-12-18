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
            )->where('status', 'active');
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
        $userCart[0]->total_items = $userCart[0]->items->count();
        foreach($userCart[0]->items as $items)
        {
            $totalAmount += $items->service !== null ? $items->service->price : 0;
        }
        $userCart[0]->total_amount = $totalAmount;

        return sendResponse($userCart, 'Get users cart');
    }

    public function addToCart(Request $request)
    {
        $data = $request->cart;
        $userCart = Cart::where('user_id', $request->user_id)->first();
        $cart = isset($userCart) ? $userCart : new Cart();

        $cart->total_items = count($data['items']);
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
        return sendResponse('Order is placed', 'Checkout user cart');
    }

    public function addItemToCart(Request $request)
    {
        $data = $request->cart;
        // $userCart = Cart::with(['items' => function($query) {
        //     $query->select('*')->where('status', 'active');
        // }])
        // ->where('id', $request->cart_id)
        // ->where('user_id', $request->user_id)->first();
        // $defaultCart = $userCart !== null ? $userCart : new Cart();

        // $totalCartAmount = 0;
        // foreach($defaultCart->items as $items)
        // {
        //     $totalCartAmount += $items->service->price;
        // }
        // $event = OccasionEvent::where('id', $request->service_id)->first();
        // $cart->total_items = $cart->items->count();
        // $cart->total_amount = $totalCartAmount + $event->price;
        // $cart->promo_code = $cart->items->promo_code;
        // $cart->save();


        // $item = new CartItem();
        // $item->cart_id = $request->cart_id;
        // $item->service_id = $request->service_id;
        // $item->schedule_start_datetime = $data['schedule_start_datetime'];
        // $item->schedule_end_datetime = $data['schedule_end_datetime'];
        // $item->guests = $data['guests'];
        // $item->save();

        $activeCart = Cart::with(['items' => function($query) {
            $query->select(
                'id',
                'cart_id',
                'service_id',
                'schedule_start_datetime',
                'schedule_end_datetime',
                'guests',
                'status'
            )->where('status', 'active');
        }])
        ->where('user_id', $data['user_id'])
        ->get([
            'id',
            'total_items',
            'total_amount',
            'promo_code',
            'user_id',
            'status'
        ]);
        $cart = $activeCart !== null ? $activeCart : new Cart();

        $cart->total_items += 1;
        $cart->total_amount += $data['total_amount'];
        return sendResponse($cart, 'New item added to cart');
    }


    public function updateItemInCart(Request $request)
    {
        $data = $request->item;
        $item = CartItem::where('cart_id', $request->cart_id)
        ->where('service_id', $request->service_id)
        ->first();
        $item->schedule_start_datetime = $data['schedule_start_datetime'];
        $item->schedule_end_datetime = $data['schedule_end_datetime'];
        $item->guests = $data['guests'];
        $item->save();
        return sendResponse('Service updated successfully.', 'Item updated');
    }

    public function removeItemFromCart(Request $request)
    {
        $item = CartItem::where('cart_id', $request->cart_id)
        ->where('service_id', $request->service_id)->first();
        $item->status = 'cancelled';
        $item->save();
        return sendResponse('Item successfully removed.', 'Item removed');
    }

    public function getItemInCartByStatus(Request $request)
    {
        $cartItem = CartItem::with('service')
        ->where('cart_id', $request->cart_id)
        ->where('status', $request->status)
        ->get();
        return sendResponse($cartItem, 'Cart items where status '. $request->status);
    }
}
