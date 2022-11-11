<?php

namespace App\Helpers\Common;

use App\Models\AuditTrail;

class GeneralHelper
{
    public static function audit_trail($notes): void
    {
        $audit_trail = new AuditTrail();
        $audit_trail->notes = $notes;
        $audit_trail->save();
    }
}
