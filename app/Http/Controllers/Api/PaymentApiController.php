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

    public function processPayment(Request $request) {

        $data = $request->payment;
        $order = Order::with('user')->where('reference_no', $data['order_id'])->get();
        $result = SkipCashUtility::postPayment($order[0]);

        if ($result !== null && $result->returnCode == 200) {
            $paymentDetails = new PaymentDetails();
            $paymentDetails->payment_method_id = $data['payment_method'];
            $paymentDetails->reference_no = $order[0]->reference_no;
            $paymentDetails->order_id = $order[0]->id;
            $paymentDetails->total = $order[0]->total_amount;
            $paymentDetails->sub_total = $order[0]->total_amount; // without vat
            $paymentDetails->discount = 0; // deduction from promo_code
            $paymentDetails->promo_code = $data['promo_code'];
            $paymentDetails->payment_id = $result->id ?? Str::uuid()->toString();
            $paymentDetails->save();
        }

        return sendResponse($result, "T");
    }

    public function getPaymentById(Request $request) {
        $paymentId = $request->payment_id;

        $skipCashUrl = config('skipcash.url');
        $skipCashClientId = config('skipcash.client_id');
        $skipCashWebhookKey = config('skipcash.webhook_key');
        $skipCashKeyId = config('skipcash.key_id');
        $skipCashSecretKey = config('skipcash.secret_key');

        return sendResponse("OK", "Payment details with payment id " . $request->payment_id);
    }
}
