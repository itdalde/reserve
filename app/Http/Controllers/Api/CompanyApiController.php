<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Models\AvailableDates;
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
        $response = [];
        foreach($providers as $k => $provider) {
            $services = [];
            if(isset($provider->services[0])) {
                $provider->base_price = OccasionEvent::where('company_id', $provider->id)->min('price');
                foreach($provider->services as $service) {
                    $availableDates = AvailableDates::where('service_id', $service['id'])
                        ->where('status', 1)
                        ->where('date_obj', '<>', null)
                        ->selectRaw('DATE(date_obj) as date')->limit(1)->get()->toArray();
                    $unavailableDates = AvailableDates::where('service_id', $service['id'])
                        ->where('status', 2)
                        ->where('date_obj', '<>', null)
                        ->selectRaw('DATE(date_obj) as date')->limit(1)->get()->toArray();
                    if($unavailableDates || $availableDates) {
                        $services[] = $service;
                    }
                }
                if(!$services) {
                    unset($providers[$k]);
                } else {
                    $response[] = $providers[$k];
                }
            } else {
               unset($providers[$k]);
            }
        }
        return sendResponse($response, 'Get providers');
    }
}
