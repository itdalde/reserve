<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditTrail;

class AuditTrailController extends Controller
{
    //

    public function index() {
        $audits = AuditTrail::where('company_id', auth()->user()->company->id)->orderBy('id', 'DESC')->get();
        return view('admin.audit.index', compact('audits'));
    }
}
