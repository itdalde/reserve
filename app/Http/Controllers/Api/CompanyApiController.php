<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\OccasionEvent;
use Illuminate\Http\Request;

class CompanyApiController extends Controller
{
    public function getProviders() {
        $providers = Company::with('serviceType', 'services', 'tags', 'reviews')->get();
        foreach($providers as $provider) {
            $provider->base_price = OccasionEvent::where('company_id', $provider->id)->min('price');
        }
        return sendResponse($providers, 'Get providers');
    }
}
