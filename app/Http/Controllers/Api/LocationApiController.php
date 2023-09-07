<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Google\Exception;
use Illuminate\Http\Request;

class LocationApiController extends Controller
{
    //

    public function addLocation(Request $request)
    {

        try {
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
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function getLocations(Request $request)
    {
        try {
            $locations = Location::where('user_id', $request->user_id)->get();
            return sendResponse($locations, 'Available Locations');
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function getDefaultLocation(Request $request)
    {

        try {
            $location = Location::where('user_id', $request->user_id)
                ->where('default', 1)
                ->first();
            return sendResponse($location, 'Default Location');
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }
}
