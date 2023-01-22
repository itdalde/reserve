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
        $skipCashClientId = config('skipcash.client_id');
        $skipCashKeyId = config('skipcash.key_id');
        $skipCashSecretKey = config('skipcash.secret_key');
        $skipCashWebhookKey = config('skipcash.webhook_key');

        $formData = [
            "uid" => Str::uuid()->toString(),
            "keyId" => $skipCashKeyId,
            "amount" => number_format($order->total_amount, 2),
            "firstName" => $order->user->first_name,
            "lastName" => $order->user->last_name,
            "phone" => $order->user->phone_number,
            "email" => $order->user->email,
            "street" => "CA",
            "city" => "Nasipit",
            "state" => "00",
            "country" => "00",
            "postCode" => "8602",
        ];

        $query = http_build_query($formData, "", ",");

        $signature = hash_hmac('sha256', json_encode($query), $skipCashSecretKey);

        $headers = [
            'Authorization: ' . base64_encode($signature),
            'Content-Type: application/json;',
            'x-client-id: ' . $skipCashClientId,
            'x-client-secret: ' . $skipCashSecretKey,
        ];
        

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $skipCashUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FILETIME, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);
        return $data;
    }
    
}