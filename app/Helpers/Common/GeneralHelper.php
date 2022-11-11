<?php

namespace App\Helpers\Common;
use Illuminate\Support\Facades\Auth;

use App\Models\AuditTrail;

class GeneralHelper
{
    public static function audit_trail($notes): void
    {
        $audit_trail = new AuditTrail();
        $audit_trail->user = Auth::user();
        $audit_trail->notes = $notes;
        $audit_trail->save();
    }
}
