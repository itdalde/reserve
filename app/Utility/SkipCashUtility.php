<?php

namespace App\Utility;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;


class SkipCashUtility
{

    use Queueable;

    private static function guidv4($data = null) {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function postPayment($sOrder) 
    {

        $skipCashUrl = config('skipcash.url') . '/api/v1/payments';
        $skipCashKeyId = config('skipcash.key_id');
        $skipCashSecretKey = config('skipcash.secret_key');
        // $skipCashClientId = config('skipcash.client_id');
        // $skipCashWebhookKey = config('skipcash.webhook_key');

        $uuid = Self::guidv4();
        $data = [];
        $data['Uid'] = $uuid;
        $data['KeyId'] = $skipCashKeyId;
        $data['Amount'] = "$sOrder->amount";
        $data['FirstName'] = $sOrder->order->user->first_name;
        $data['LastName'] = $sOrder->order->user->last_name;
        $data['Phone'] = $sOrder->order->user->phone_number;
        $data['Email'] = $sOrder->order->user->email;
        $data['Street'] = "st";
        $data['City'] = "TempCity";
        $data['State'] = "QA";
        $data['Country'] = "QA";
        $data['PostalCode'] = "01238";
        $data['TransactionId'] = $sOrder->reference_no;
        $data_string = json_encode($data);
        $resultheader = 'Uid=' . $data['Uid'] . ',KeyId=' . $data['KeyId'] . ',Amount=' . $data['Amount'] . ',FirstName=' . $data['FirstName'] . ',LastName=' . $data['LastName'] . ',Phone=' . $data['Phone'] . ',Email=' . $data['Email']. ',Street=' . $data['Street']. ',City=' . $data['City']. ',State=' . $data['State']. ',Country=' . $data['Country']. ',PostalCode=' . $data['PostalCode']. ',TransactionId=' . $data['TransactionId'];
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

    public static function processPaymentHooks($request) {
        
        $webhookUrl = 'https://reservegcc.com/api/v1/payments/processed';
        $skipCashSecretKey = config('skipcash.secret_key');
        $data = [];
        $data['PaymentId'] = $request['PaymentId'];
        $data['Amount'] = $request['Amount'];
        $data['StatusId'] = $request['StatusId'];
        $data['TransactionId'] = $request['TransactionId'];
        $data['CustomId'] = $request['CustomId'];
        $data['VisaId'] = $request['VisaId'];
        
        $data_string = json_encode($data);

        $resultheader = 'PaymentId='.$data['PaymentId'].',Amount='.$data['Amount'].',StatusId='.$data['StatusId'].',TransactionId='.$data['TransactionId'].',Custom1='.$data['Custom1'].',VisaId=' . $data['VisaId'];
        $signature = hash_hmac('sha256', $resultheader, $skipCashSecretKey, true);
        $authorisationheader = base64_encode($signature);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $webhookUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . $authorisationheader,
                'Content-Type: application/json'
            )
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, null);
        return $response;
    }
    
}