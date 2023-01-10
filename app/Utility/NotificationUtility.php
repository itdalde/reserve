<?php

namespace App\Utility;


use Illuminate\Bus\Queueable;

class NotificationUtility
{
    use Queueable;

    public static function  sendNotification($title,$body,$fcmTokens,$data=[])
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $apiKey = config('larafirebase.authentication_key');

        $fcmNotification = [
            "registration_ids" => $fcmTokens,
            "notification" => [
                "title" => $title,
                "body" => $body
            ],
            "data" => [
                'title' => $title,
                'data' =>$data
            ]
        ];
        $headers = [
            "Authorization: key=" . $apiKey,
            "Content-Type: application/json"
        ];

        $encodedData = json_encode($fcmNotification);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($ch);
//        if ($result === FALSE) {
//            die("Curl failed: " . curl_error($ch));
//        }
        curl_close($ch);
        return ["status" => 1, "message" => "Notification sent to users", "payload" => $result];

    }
}
