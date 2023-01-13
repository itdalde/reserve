<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationApiController extends Controller
{
    //

    public function addLocation(Request $request) {
        
        $data = $request->location;
        $location = new Location();
        $location->user_id = $data['user_id'];
        $location->address = $data['address'];
        $location->default = $data['default'];
        $location->save();
        $savedLocation = [
            'user_id' => $location->user_id,
            'address' => $location->address,
            'default' => $location->default,
            'id' => $location->id
        ];
        return sendResponse($savedLocation, 'New location saved successfully!');
    }

    public function getLocations(Request $request) {
        $locations = Location::all();
        return sendResponse($locations, 'Available Locations');
    }

    public function getDefaultLocation(Request $request) {

        $location = Location::where('user_id', $request->user_id)
        ->where('default', 1)
        ->first();
        return sendResponse($location, 'Default Location');
    }
}
