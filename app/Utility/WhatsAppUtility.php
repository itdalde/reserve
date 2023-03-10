<?php

namespace App\Utility;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Infobip\InfobipClient;
use Infobip\Resources\SMS\Models\Destination;

class WhatsAppUtility
{

  use Queueable;

  public static function sendWhatsAppMessage()
  {
   
    return "Ok";
  }

  public static function sendWithTemplate()
  {

    $client = new Client([
      'base_uri' => config('infobip.base_url'),
      'headers' => [
        'Authorization' => 'App ' . config('infobip.api_key'),
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
      ]
    ]);

    $response = $client->request(
      'POST',
      'whatsapp/1/message/template',
      [
        RequestOptions::JSON => [
          'messages' => [
            [
              'from' => '447860099299',
              'to' => "639754120343",
              'content' => [
                'templateName' => 'registration_success',
                'templateData' => [
                  'body' => [
                    'placeholders' => ['sender', 'message', 'delivered', 'testing']
                  ],
                  'header' => [
                    'type' => 'IMAGE',
                    'mediaUrl' => 'https://api.infobip.com/ott/1/media/infobipLogo',
                  ],
                  'buttons' => [
                    ['type' => 'QUICK_REPLY', 'parameter' => 'yes-payload'],
                    ['type' => 'QUICK_REPLY', 'parameter' => 'no-payload'],
                    ['type' => 'QUICK_REPLY', 'parameter' => 'later-payload']
                  ]
                ],
                'language' => 'en',
              ],
            ]
          ]
        ]
      ]
    );

    return $response->getBody()->getContents();
  }
}
