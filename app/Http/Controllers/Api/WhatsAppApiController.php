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
        try {

            $res = WhatsAppUtility::sendWhatsAppMessage();

            return sendResponse($res, "OPK");
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function sendWithTemplate(Request $request)
    {
        try {
            $response = WhatsAppUtility::sendWithTemplate();
            return sendResponse($response, "OK");
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }
}
