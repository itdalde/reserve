<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyApiController extends Controller
{
    //


    public function getProviders() {
        $providers = Company::all();
        return sendResponse($providers, 'Get providers');
    }
}
