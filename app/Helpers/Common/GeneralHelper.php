<?php

namespace App\Helpers\Common;
use Illuminate\Support\Facades\Auth;

use App\Models\AuditTrail;
use App\Models\OrderSplit;
use Illuminate\Support\Facades\File;

class GeneralHelper
{
    public static function audit_trail($notes): void
    {
        $audit_trail = new AuditTrail();
        $audit_trail->user = Auth::user();
        $audit_trail->notes = $notes;
        $audit_trail->save();
    }

    public static function referenceNo()
    {
        return str_pad(mt_rand(1, substr(time(), 1, -1)), 8, '0', STR_PAD_LEFT);
    }

    public static function paymentStatus($code)
    {
        return $code == 2 ? 'Paid' : Self::paymentFailed($code);
    }

    public static function orderBalance($orderId, $status)
    {
        return OrderSplit::where('order_id', $orderId)->where('status', $status)->sum('amount');
    }

    // PRIVATE
    private static function paymentFailed($code)
    {
        return $code == 3 ? 'Cancelled' : 'Failed';
    }

    public static function getTranslation($locale, $key = null)
    {
        $lang = File::get(resource_path('lang/'. $locale .'.json'));
        $decoded_lang = json_decode($lang, true);
        $translation = $decoded_lang;
        if ($key)
        {
            $translation = $decoded_lang[$key];
        }

        return $translation;
        
    }
}
