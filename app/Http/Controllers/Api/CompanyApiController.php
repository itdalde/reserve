<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Models\Company;
use App\Models\OccasionEvent;

class CompanyApiController extends Controller
{
    public function getProviders() {

        $users = User::whereHas('company')->with('roles')->sortable(['email' => 'asc'])->get();
        $usersIds = [];
        foreach ($users as $user) {
            if((!$user->hasRole('superadmin'))) {
                $usersIds[] = $user->company->id;
            }
        }

        $providers = Company::whereIn('id',$usersIds)->with('serviceType', 'services', 'reviews')->get();
        foreach($providers as $provider) {
            $provider->base_price = OccasionEvent::where('company_id', $provider->id)->min('price');
        }
        return sendResponse($providers, 'Get providers');
    }
}
