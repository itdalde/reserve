<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\SocialLogin;
use App\Http\Controllers\Controller;
use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Notifications\Auth\ConfirmEmail;
use Carbon\Carbon as Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Ramsey\Uuid\Uuid;

class ApiAuthController extends Controller
{
    public function register (Request $request) {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'phone_number' => 'string|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if(!isset($data['email']) && !isset($data['phone_number'])) {
            return response(['message'=> 'Please add required email'], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => Uuid::uuid4(),
            'confirmed' => false
        ]);
        if (config('auth.users.default_role')) {
            $user->roles()->attach(Role::firstOrCreate(['name' =>'user']));
        }

        $to = "somebody@example.com";
        $subject = "Welcome";
        $txt = "Welcome to Reserve";
        $headers = "From: contactus@reservegcc.com";

        mail($to,$subject,$txt,$headers);
//        $user->notify(new ConfirmEmail());
        $response = ['message' => 'Successfully created. Please check your email to confirm'];
        return response()->json($response,200);
    }

    public function resendConfirmation(Request $request) {
        $user = User::where('email',$request->email)->first();
        if(!$user) {
            return response(['message'=>'User not found'], 422);
        }
        $user->notify(new ConfirmEmail());
        $response = ['message' => 'Successfully sent consfirmation. Please check your email to confirm'];
        return response()->json($response,200);
    }

    public function login (Request $request) {
        $data = $request->all();
        $validatorRule['password'] = 'required|string';
        if(isset($data['phone'])) {
            $validatorRule['phone'] = 'required|string|max:255';
            $searchKey = 'phone_number';
            $search = $request->email;
        } else {
            $validatorRule['email'] = 'required|string|email|max:255';
            $searchKey = 'email';
            $search = $request->email;
        }
        $validator = Validator::make($data, $validatorRule);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where($searchKey, $search)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if (config('auth.users.confirm_email') && !$user->confirmed) {
                    $response = ['message' => 'Please confirm user first'];
                    return response()->json($response,422);
                }
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = [
                    'message' => 'Successfully login',
                    'data' => $token
                ];
                return response()->json($response,200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function me (Request $request) {
        $user = $request->user()->toArray();
        return response()->json($user, 200);
    }
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
    public function googleLogin(Request $request) {
        try {
            $token = $request->token;
            if(!$token) {
                $response = ["message" =>'Missing required token'];
                return response()->json($response, 422);
            }
            $decoded = (array)json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))));
            if (!isset($decoded['email'])) {
                $response = ["message" =>'Invalid token'];
                return response()->json($response, 422);
            }
            $user = User::where('email', $decoded['email'])->first();
            if (!$user) {
                $user = new User;
                $user->full_name = $decoded['name'] ?? '';
                $user->email = $decoded['email'] ?? '';
                $user->google_id = $decoded['id'] ?? '';
                $user->profile_picture = $decoded['avatar'] ?? '';
                $user->password = bcrypt(Uuid::uuid4());
                $user->confirmation_code = Uuid::uuid4();
                $user->confirmed = true;
                $user->active = true;
                $user->email_verified_at = Carbon::now();
                $user->save();
            }
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['token' => $token];
            return response()->json($response, 200);
        }catch (\Exception $exception) {
            $response = ["message" =>'Invalid token'];
            return response()->json($response, 422);
        }
    }
}
