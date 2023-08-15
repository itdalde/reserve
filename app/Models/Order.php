<?php

namespace App\Models;

use App\Models\Auth\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    public function items() {
        return $this->hasMany(OrderItems::class)->with('service','adOns');
    }

    public function paymentMethod() {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method')
            ->select('id', 'card_type', 'name', 'expiry_date', 'last_four_digit', 'cvv', 'is_active');
    }
    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function paymentDetails() {
        return $this->hasOne(PaymentDetails::class, 'order_id', 'id');
    }

    public function splitOrder() {
        return $this->hasMany(OrderSplit::class, 'order_id', 'id');
    }
    public function balance() {
        return $this->hasMany(OrderSplit::class, 'order_id', 'id')->where('status', 'pending')->sum('amount');
    }
    public function total_paid() {
        return $this->hasMany(OrderSplit::class, 'order_id', 'id')->where('status', 'paid')->sum('amount');
    }
    public function adOns() {
        return $this->hasMany(OrderAdOns::class, 'order_id', 'id');
    }
}
