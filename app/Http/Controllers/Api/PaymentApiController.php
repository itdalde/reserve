<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentDetails;
use App\Utility\SkipCashUtility;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PaymentApiController extends Controller
{
    //

    public function processPayment(Request $request)
    {

        $data = $request->payment;
        $order = Order::with('user')->where('reference_no', $data['order_id'])->get();
        $result = SkipCashUtility::postPayment($order[0]);
        if ($result['returnCode'] == 200) {
            $paymentDetails = new PaymentDetails();
            $paymentDetails->payment_method_id = $data['payment_method'];
            $paymentDetails->reference_no = $result['resultObj']['transactionId'];
            $paymentDetails->order_id = $order[0]->id;
            $paymentDetails->total = $result['resultObj']['amount'];
            $paymentDetails->sub_total = $result['resultObj']['amount']; // without vat
            $paymentDetails->discount = 0; // deduction from promo_code
            $paymentDetails->promo_code = $data['promo_code'];
            $paymentDetails->payment_id = $result['resultObj']['id'];
            $paymentDetails->payment_url = $result['resultObj']['payUrl'];
            $paymentDetails->currency = $result['resultObj']['currency'];
            $paymentDetails->save();
        }

        return sendResponse($result, $result['returnCode'] == 200 ? "Success" : "Failed");
    }

    public function getProcessPayment(Request $request)
    {
        $paymentId = $request->payment_id;

        $result = SkipCashUtility::getPaymentDetail($paymentId);

        return sendResponse($result, "Payment details with payment id " . $request->payment_id);
    }
}
