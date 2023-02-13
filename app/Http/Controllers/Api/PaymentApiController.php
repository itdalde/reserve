<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Common\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderSplit;
use App\Models\PaymentDetails;
use App\Models\PaymentEvents;
use App\Utility\SkipCashUtility;
use Illuminate\Http\Request;

class PaymentApiController extends Controller
{
    //

    public function processPayment(Request $request)
    {

        $data = $request->payment;
        // $order = Order::with('user')->where('reference_no', $data['order_id'])->first();
        $orderSplit = OrderSplit::with('order')->where('reference_order', $data['order_id'])->where('status', 'pending')->first();
        if ($orderSplit == null) {
            return sendResponse('There is no transaction under the reference no. provided.', 'Unable to process payment');
        }
        $result = SkipCashUtility::postPayment($orderSplit);
        if ($result['returnCode'] == 200) {
            $paymentDetails = new PaymentDetails();
            $paymentDetails->payment_method_id = $data['payment_method'];
            $paymentDetails->reference_no = $result['resultObj']['transactionId'];
            $paymentDetails->order_id = $orderSplit->order->id;
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

    public function paymentProcessing(Request $request) {
     
        $pe = new PaymentEvents();
        $pe->payment_id = $request['PaymentId'];
        $pe->amount = $request['Amount'];
        $pe->status_id = $request['StatusId'];
        $pe->status = GeneralHelper::paymentStatus(isset($request['StatusId']));
        $pe->transaction_id = $request['TransactionId'];
        $pe->custom_1 = $request['Custom1'];
        $pe->visa_id = $request['VisaId'];
        $pe->save();

        $os = OrderSplit::where('reference_no', $pe->transaction_id)->first();
        $o = Order::where('reference_no', $os->reference_order)->first();
        $oi = OrderItems::where('order_id', $o->id)->get();

        $totalPaid = $os->where('reference_order', $o->reference_no)->where('status', 'paid')->sum('amount');
        if ($totalPaid != $o->total_amount) {
            $o->status = 'processing';
            $o->timeline = 'processing';
            foreach($oi as $item)
            {
                $item->status = 'processing';
                $item->timeline = 'processing';
                $item->save();
            }
        } else {
            $o->status = 'completed';
            $o->timeline = 'order-completed';
            foreach($oi as $item)
            {
                $item->status = 'completed';
                $item->timeline = 'order-completed';
                $item->save();
            }
        }
        $o->save();

        $os->status = 'paid';
        $os->save();
        return sendResponse($pe, "SkipCash Response");
    }

    public function paymentSuccess(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');
            $statusId = $request->input('statusId');
            $status = $request->input('status');
            $transId = $request->input('transId');
            $custom1 = $request->input('custom1');
        }

        $data = [
            'data' => [
                'id' => $id ?? '',
                'transId' => $transId ?? '',
                'custom1' => $custom1 ?? ''
            ],
            'status' => $status ?? '',
            'statusId' => $statusId ?? '',
        ]; 
        return sendResponse($data, $status == "Failed" ? "Payment Failed" : "Payment Successfull");
    }

    public function paymentReceipt(Request $request)
    {
        $paymentDetails = PaymentDetails::where('reference_no', $request->reference_no)->first();

        $orderReceipt = [
            'reference_no' => $request->reference_no,
            'url' => config('skipcash.url') . '/pay/'.$paymentDetails->payment_id.'/receipt'
        ];

        return sendResponse($orderReceipt, "Skip cash payment receipt");
    }
}
