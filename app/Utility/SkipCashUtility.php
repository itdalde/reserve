<?php

namespace App\Utility;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;


class SkipCashUtility
{

    use Queueable;

    public static function postPayment($order) 
    {

        $skipCashUrl = config('skipcash.url') . '/api/v1/payments';
        $skipCashKeyId = config('skipcash.key_id');
        $skipCashSecretKey = config('skipcash.secret_key');
        // $skipCashClientId = config('skipcash.client_id');
        // $skipCashWebhookKey = config('skipcash.webhook_key');

        $uuid = Str::uuid()->toString();
        $data = [];
        $data['Uid'] = $uuid;
        $data['KeyId'] = $skipCashKeyId;
        $data['Amount'] = "$order->total_amount";
        $data['FirstName'] = $order->user->first_name;
        $data['LastName'] = $order->user->last_name;
        $data['Phone'] = $order->user->phone_number;
        $data['Email'] = $order->user->email;
        $data['Street'] = "st";
        $data['City'] = "TempCity";
        $data['State'] = "QA";
        $data['Country'] = "QA";
        $data['PostalCode'] = "01238";
        $data['TransactionId'] = $order->reference_no;
        $data_string = json_encode($data);
        $resultheader = "Uid=" . $data['Uid'] . ',KeyId=' . $data['KeyId'] . ',Amount=' . $data['Amount'] . ',FirstName=' . $data['FirstName'] . ',LastName=' . $data['LastName'] . ',Phone=' . $data['Phone'] . ',Email=' . $data['Email']. ',Street=' . $data['Street']. ',City=' . $data['City']. ',State=' . $data['State']. ',Country=' . $data['Country']. ',PostalCode=' . $data['PostalCode']. ',TransactionId=' . $data['TransactionId'];
        $signature = hash_hmac('sha256', $resultheader, $skipCashSecretKey, true);
        $authorisationheader = base64_encode($signature);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $skipCashUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . $authorisationheader,
                'Content-Type:application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        return $response;
    }

    public static function getPaymentDetail($paymentId = null)
    {
        $skipCashUrl = config('skipcash.url') . '/api/v1/payments/';
        $skipCashClientId = config('skipcash.client_id');

     
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $skipCashUrl . $paymentId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Content-Type:application/json', 'Accept: application/json', 'Authorization: ' . $skipCashClientId
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);

        return $response;
    }
    
}