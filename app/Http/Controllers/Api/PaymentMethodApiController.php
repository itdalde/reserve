<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;


class PaymentMethodApiController extends Controller
{
    //

    public function getPaymentMethodById(Request $request) {

        $paymentMethod = PaymentMethod::where('id', $request->payment_method_id)->first();

        return sendResponse($paymentMethod, 'Payment method with id '. $request->payment_method_id);
    }

    public function savePaymentMethod(Request $request) {

        $data = $request->payment_method;

        $paymentType = new PaymentMethod();
        $paymentType->card_type = $data['card_type'];
        $paymentType->name = $data['name'];
        $paymentType->expiry_date = $data['expiry_date'];
        $paymentType->last_four_digit = $data['last_four_digit'];
        $paymentType->cvv = $data['cvv'];
        $paymentType->is_active = $data['is_active'];
        $paymentType->save();
        return sendResponse($paymentType, 'Payment method successfully saved.');
    }
}
