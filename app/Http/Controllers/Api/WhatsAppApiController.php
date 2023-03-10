<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utility\WhatsAppUtility;
use Illuminate\Http\Request;

class WhatsAppApiController extends Controller
{
    //

    public function sendWhatsAppMessage(Request $request)
    {
        $res = WhatsAppUtility::sendWhatsAppMessage();

        return sendResponse($res, "OPK");
    }

    public function sendWithTemplate(Request $request)
    {

        $response = WhatsAppUtility::sendWithTemplate();
        return sendResponse($response, "OK");
    }
}
