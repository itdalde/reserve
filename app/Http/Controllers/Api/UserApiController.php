<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use Mockery\Exception;

class UserApiController extends Controller
{
    //

    public function updateUser(Request $request)
    {
        try {
            $data = $request->user;

            $profile = User::where('id', $request->user_id)->first();

            if ($request->file('profile_picture')) {
                $file = $request->file('profile_picture');
                $imageName = time() . '.' . $file->extension();
                $file->move(public_path('assets/images/avatar'), $imageName);
                $filename = "assets/images/avatar/{$imageName}";
                $profile->profile_picture = $filename;
            }
            $firstName = $data['first_name'] ?? $profile->first_name;
            $lastName = $data['last_name'] ?? $profile->last_name;
            $fcm_token = $data['fcm_token'] ?? $profile->fcm_token;
            $profile->first_name = $firstName;
            $profile->last_name = $lastName;
            $profile->fcm_token = $fcm_token;
            $profile->location = $data['location'] ?? $profile->location;
            $profile->full_name = $firstName . ' ' . $lastName;
            $profile->phone_number = $data['phone_number'] ?? $profile->phone_number;
            // $profile->profile_picture = $data['profile_picture'] ?? null;
            // $profile->email = $data['email'] ?? $profile->email;
            $profile->gender = $data['gender'] ?? $profile->gender;
            $profile->birth_date = $data['birth_date'] ?? $profile->birth_date;
            $profile->update();

            return sendResponse($profile, "Profile Updated");
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }

    public function updateUserAppLanguage(Request $request)
    {
        try {

            $profile = User::where('id', $request->user_id)->first();
            $profile->app_language = $request->lang;
            $profile->save();
            return sendResponse($request->all(), "Language Updated");
        } catch (\Exception $exception) {
            return sendError($exception->getMessage(), $request->all(), 401);
        }
    }

    public function updateProfilePicture(Request $request)
    {
        try {

            $profile = User::where('id', $request->user_id)->first();
            if ($request->file('profile_picture')) {
                $file = $request->file('profile_picture');
                $imageName = time() . '.' . $file->extension();
                $file->move(public_path('assets/images/avatar'), $imageName);
                $filename = "assets/images/avatar/{$imageName}";
                $profile->profile_picture = $filename;
            }
            return sendResponse($request->file, "Image profile updated");
        } catch (\Exception $exception) {
            return sendError('Something went wrong', $exception->getMessage(), 422);
        }
    }
}
