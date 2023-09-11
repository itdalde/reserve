<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Common\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderSplit;
use App\Models\PaymentDetails;
use App\Models\PaymentEvents;
use App\Models\Promotions;
use App\Models\UserPromotions;
use App\Utility\SkipCashUtility;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentApiController extends Controller
{
    //

    public function processPayment(Request $request)
    {
        try {

            $data = $request->payment;
            $promotion = null;
            // $order = Order::with('user')->where('reference_no', $data['order_id'])->first();
            $orderSplit = OrderSplit::with('order')->where('reference_order', $data['order_id'])->where('status', 'pending')->first();
            if ($orderSplit == null) {
                return sendError('There is no transaction under the reference no. provided.', 'Unable to process payment');
            }
            $amount =  $orderSplit->amount;
            $promotion = null;
            if (isset($data['promo_code']) && $data['promo_code']) {
                $promotion = Promotions::where('promotions.code', '=', $data['promo_code'])->first();
                if (!$promotion) {
                    return sendError('Invalid promo code', 'Unable to process payment');
                }
                if ($promotion->status == 0) {
                    return sendError('Promo code is not active', 'Unable to process payment');
                }

                if ($promotion->single_use) {
                    $hasUsePromotion = UserPromotions::where('promotion_id', '=', $promotion->id)->where('user_id', '=', $orderSplit->order->user_id)->first();
                    if ($hasUsePromotion) {
                        return sendError('Promo code is already use', 'Unable to process payment');
                    }
                } else {
                    $start_date = Carbon::parse($promotion->start_date);
                    $end_date = Carbon::parse($promotion->end_date);
                    $date_to_check = Carbon::now();
                    if (!$date_to_check->between($start_date, $end_date)) {
                        $date_to_check = Carbon::parse($promotion->end_date);
                        if ($date_to_check->isPast()) {
                            return sendError('Promo code is already expired', 'Unable to process payment');
                        } else {
                            return sendError('Promo is not started yet', 'Unable to process payment');
                        }
                    }
                    if ($promotion->quantity < 1) {
                        return sendError('Promo code is fully redeemed', 'Unable to process payment');
                    }
                }
                if($promotion->percent) {
                    $orderSplit->amount = ($promotion->percent / 100) * $orderSplit->amount;
                } else {
                    $orderSplit->amount =  $promotion->price <= $orderSplit->amount ?  (float)$orderSplit->amount - (float)$promotion->price : 0;
                }
            }
            $result = SkipCashUtility::postPayment($orderSplit);
            if (!$result) {
                return sendError('Skip Cash Error', 'Unable to process payment');
            }
            if (isset($result['returnCode']) && $result['returnCode'] == 200) {
                $paymentDetails = new PaymentDetails();
                $paymentDetails->payment_method_id = $data['payment_method'];
                $paymentDetails->reference_no = $result['resultObj']['transactionId'];
                $paymentDetails->order_id = $orderSplit->order->id;
                $paymentDetails->total = $amount;
                $paymentDetails->sub_total = $amount; // without vat
                $paymentDetails->discount =  $promotion ? $orderSplit->amount : 0; // deduction from promo_code
                $paymentDetails->promo_code = isset($data['promo_code']) ? $data['promo_code'] : '';
                $paymentDetails->payment_id = $result['resultObj']['id'];
                $paymentDetails->payment_url = $result['resultObj']['payUrl'];
                $paymentDetails->currency = $result['resultObj']['currency'];
                $paymentDetails->save();
                if ($promotion) {
                    $userPromo = new UserPromotions();
                    $userPromo->user_id = $orderSplit->order->user_id;
                    $userPromo->promotion_id = $promotion->id;
                    $userPromo->save();
                    $promotion->quantity = $promotion->quantity < 0 ?  $promotion->quantity - 1 : 0;
                    $promotion->save();
                }
            }
            return sendResponse($result, isset($result['returnCode']) && $result['returnCode'] == 200 ? "Success" : "Failed");

        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function getProcessPayment(Request $request)
    {
        try {
            $paymentId = $request->payment_id;

            $result = SkipCashUtility::getPaymentDetail($paymentId);

            return sendResponse($result, "Payment details with payment id " . $request->payment_id);
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function paymentProcessing(Request $request)
    {

        try {
            $pe = new PaymentEvents();
            $pe->payment_id = $request['PaymentId'];
            $pe->amount = $request['Amount'];
            $pe->status_id = $request['StatusId'];
            $pe->status = GeneralHelper::paymentStatus(isset($request['StatusId']));
            $pe->transaction_id = $request['TransactionId'];
            $pe->custom_1 = $request['Custom1'];
            $pe->visa_id = $request['VisaId'];
            $pe->save();


            // $o = Order::where('reference_no', $os->reference_order)->first();
            // $oi = OrderItems::where('order_id', $o->id)->get();

            // foreach($oi as $item)
            // {
            //     $item->save();
            // }
            // $o->save();
            $os = OrderSplit::where('reference_no', $pe->transaction_id)->first();
            $os->status = $request['StatusId'] == 2 ? 'paid' : 'pending';
            $os->save();
            return sendResponse($pe, "SkipCash Response");
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function paymentSuccess(Request $request)
    {
        try {
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
            return sendResponse($data, $status == "Failed" ? "Payment Failed" : "Payment Successful");
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function paymentReceipt(Request $request)
    {
        try {
            $paymentDetails = PaymentDetails::where('reference_no', $request->reference_no)->first();

            $orderReceipt = [
                'reference_no' => $request->reference_no,
                'url' => config('skipcash.url') . '/pay/' . $paymentDetails->payment_id . '/receipt'
            ];

            return sendResponse($orderReceipt, "Skip cash payment receipt");
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }
}
