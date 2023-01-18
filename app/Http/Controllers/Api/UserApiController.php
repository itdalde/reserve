<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    //

    public function updateUser(Request $request) {

        $data = $request->user;

        $profile = User::where('id', $request->user_id)->first();

        if ($request->file('profile_picture')) {
            $file = $request->file('profile_picture');
            $imageName = time() . '.' . $file->extension();
            $file->move(public_path('assets/images/avatar'), $imageName);
            $filename = "assets/images/avatar/{$imageName}";
            $profile->profile_picture = $filename;
        }

        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->location = $data['location'] ?? null;
        $profile->full_name = $data['first_name'] . ' ' . $data['last_name'];
        $profile->phone_number = $data['phone_number'] ?? null;
        // $profile->profile_picture = $data['profile_picture'] ?? null;
        // $profile->email = $data['email'] ?? $profile->email;
        $profile->gender = $data['gender'] ?? null;
        $profile->birth_date = $data['birth_date'] ?? null;
        $profile->update();

        return sendResponse($profile, "Profile Updated");
    }

    public function updateProfilePicture(Request $request) {
        $profile = User::where('id', $request->user_id)->first();
        if ($request->file('profile_picture')) {
            $file = $request->file('profile_picture');
            $imageName = time() . '.' . $file->extension();
            $file->move(public_path('assets/images/avatar'), $imageName);
            $filename = "assets/images/avatar/{$imageName}";
            $profile->profile_picture = $filename;
        }
        return sendResponse($profile, "Image profile updated");
    }
}
