<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\SocialLogin;
use App\Http\Controllers\Controller;
use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Notifications\Auth\ConfirmEmail;
use Carbon\Carbon as Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            return response()->json([
                'status' => 'fail',
                'message' => 'Something went wrong',
                'data' => $validator->errors()->all()
            ], 422);
        }
        if(!isset($data['email']) && !isset($data['phone_number'])) {

            return response()->json([
                'status' => 'fail',
                'message' => 'Please add required email',
                'data' => $data
            ], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $confirmationCode = Uuid::uuid4();
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => bcrypt($data['password']),
            'fcm_token' =>  $data['fcm_token'] ?? '',
            'confirmation_code' => $confirmationCode,
            'confirmed' => false
        ]);
        if (config('auth.users.default_role')) {
            $user->roles()->attach(Role::firstOrCreate(['name' =>'user']));
        }

        $this->sendEmail($data,$confirmationCode);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully created. Please check your email to confirm',
            'data' => $data
        ], 200);
    }

    private function sendEmail($data,$confirmationCode) {

        $to = $data['email'];
        $subject = "Welcome to Reserve";
        $style = '<style type="text/css">
          body,
          table,
          td,
          a {
            -ms-text-size-adjust: 100%; /* 1 */
            -webkit-text-size-adjust: 100%; /* 2 */
          }
          table,
          td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
          }
          img {
            -ms-interpolation-mode: bicubic;
          }
          a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
          }
          div[style*="margin: 16px 0;"] {
            margin: 0 !important;
          }
          body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
          }
          table {
            border-collapse: collapse !important;
          }
          a {
            color: #1a82e2;
          }
          img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
          }
          </style>';
        $confirm = route('confirm', [$confirmationCode]);
        $message = ' <!DOCTYPE html>
        <html>
        <head>

          <meta charset="utf-8">
          <meta http-equiv="x-ua-compatible" content="ie=edge">
          <title>Email Confirmation</title>
          <meta name="viewport" content="width=device-width, initial-scale=1">
          '.$style.'

        </head>
            <body style="background-color: #e9ecef;">
              <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
                   Hello '.$data["first_name"]." ".$data["last_name"].',
              </div>
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td align="center" bgcolor="#e9ecef">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                      <tr>
                        <td align="center" valign="top" style="padding: 36px 24px;">
                          <a href="https://reservegcc.com" target="_blank" style="display: inline-block;">
                            <img src="https://reservegcc.com/assets/landing/img/logo-black.png" alt="Logo" border="0" width="48" style="display: block; width: 48px; max-width: 48px; min-width: 48px;">
                          </a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#e9ecef">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                      <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0;  border-top: 3px solid #d4dadf;">
                          <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Confirm Your Email Address</h1>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#e9ecef">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                      <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px;  font-size: 16px; line-height: 24px;">
                          <p style="margin: 0;">Tap the button below to confirm your email address. If you didn\'t create an account with <a href="https://reservegcc.com">Reservegcc</a>, you can safely delete this email.</p>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" bgcolor="#ffffff">
                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                              <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                                <table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                                      <a href="'.$confirm.'" target="_blank" style="display: inline-block; padding: 16px 36px;  font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">Confirm</a>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px;  font-size: 16px; line-height: 24px;">
                          <p style="margin: 0;">If that doesnt work, copy and paste the following link in your browser:</p>
                          <p style="margin: 0;"><a href="'.$confirm.'" target="_blank">'.$confirm.'</a></p>
                        </td>
                      </tr>
                    </table>
                    </td>
                    </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </body>
            </html>
        ';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <contactus@reservegcc.com>' . "\r\n";
        return mail($to,$subject,$message,$headers);
    }

    public function resendConfirmation(Request $request) {
        $user = User::where('email',$request->email)->first();
        if(!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found',
                'data' => $request->email
            ], 422);
        }
        $data = [
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
        ];
        try {
            $sent  = $this->sendEmail($data,$user->confirmation_code);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Something went wrong',
                'data' => $e->getMessage()
            ], 422);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully sent confirmation. Please check your email to confirm',
            'data' => $request->all()
        ], 200);

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
            return response()->json([
                'status' => 'fail',
                'message' => 'Something went wrong',
                'data' => $validator->errors()->all()
            ], 422);
        }
        $user = User::where($searchKey, $search)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if (config('auth.users.confirm_email') && !$user->confirmed) {
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'Please confirm user first',
                        'data' => $request->all()
                    ], 422);
                }
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully login',
                    'data' => $token
                ], 200);
                return response()->json($response,200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Password mismatch',
                    'data' => $request->all()
                ], 422);
            }
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'User does not exist',
                'data' => $request->all()
            ], 422);
        }
    }

    public function me (Request $request) {
        $user = $request->user()->toArray();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetch data',
            'data' => $user
        ], 200);
    }
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke(); ;

        return response()->json([
            'status' => 'success',
            'message' => 'You have been successfully logged out!',
            'data' => $token
        ], 200);
    }
    public function googleLogin(Request $request) {
        try {
            $token = $request->token;
            if(!$token) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Missing required token',
                    'data' => [
                        'token' => $token,
                    ]
                ], 422);
            }
            $decoded = (array)json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))));
            if (!isset($decoded['email'])) {

                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid token',
                    'data' => [
                        'token' => $token,
                    ]
                ], 422);
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
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully login',
                'data' => [
                    'token' => $token,
                    'user' => $user
                ]
            ], 200);
        }catch (\Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Invalid token',
                'data' => [
                    'token' => $token,
                    'error_message' => $exception->getMessage()
                ]
            ], 401);
        }
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Something went wrong',
                'data' => $validator->errors()->all()
            ], 422);
        }
        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found!',
                'data' => $request->all()
            ], 422);
        }
        $restToken = DB::table('password_resets')
            ->where('token', $request->token)
            ->where('email', $request->email)->first();

        if(!$restToken) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Request reset password not found. Please check token!',
                'data' => $request->all()
            ], 422);
        }
        $restToken = DB::table('password_resets')
            ->where('token', $request->token)
            ->where('email', $request->email)->delete();
        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response()->json([
            'status' => 'success',
            'message' => 'You have been successfully reset password!',
            'data' => $token
        ], 200);
    }
    public function forgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Validation error',
                'data' => $validator->errors()->all()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'User not found!',
                'data' => $request->all()
            ], 422);
        }
        $token = random_int(100000, 999999);
        DB::table('password_resets')->where('email', $request->email)->delete();
        $this->sendForgotEmail($user,$token);
        DB::table('password_resets')->insert(
            array('email' => $request->email, 'token' => $token)
        );
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully requested password reset',
            'data' => [
                'token' => $token,
                'email' => $request->email
            ]
        ], 200);
    }

    private function sendForgotEmail($user,$token) {

        $to = $user->email;
        $subject = "Forgot Password";
        $style = '<style type="text/css">
          body,
          table,
          td,
          a {
            -ms-text-size-adjust: 100%; /* 1 */
            -webkit-text-size-adjust: 100%; /* 2 */
          }
          table,
          td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
          }
          img {
            -ms-interpolation-mode: bicubic;
          }
          a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
          }
          div[style*="margin: 16px 0;"] {
            margin: 0 !important;
          }
          body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
          }
          table {
            border-collapse: collapse !important;
          }
          a {
            color: #1a82e2;
          }
          img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
          }
          </style>';
        $message = ' <!DOCTYPE html>
        <html>
        <head>

          <meta charset="utf-8">
          <meta http-equiv="x-ua-compatible" content="ie=edge">
          <title>Email Forgot Password</title>
          <meta name="viewport" content="width=device-width, initial-scale=1">
          '.$style.'

        </head>
            <body style="background-color: #e9ecef;">
              <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
                   Hello '.$user->first_name." ".$user->last_name.',
              </div>
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td align="center" bgcolor="#e9ecef">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                      <tr>
                        <td align="center" valign="top" style="padding: 36px 24px;">
                          <a href="https://reservegcc.com" target="_blank" style="display: inline-block;">
                            <img src="https://reservegcc.com/assets/landing/img/logo-black.png" alt="Logo" border="0" width="48" style="display: block; width: 48px; max-width: 48px; min-width: 48px;">
                          </a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#e9ecef">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                      <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0;  border-top: 3px solid #d4dadf;">
                          <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">This is your reset token code '.$token.'</h1>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </body>
            </html>
        ';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <contactus@reservegcc.com>' . "\r\n";
        return mail($to,$subject,$message,$headers);
    }
}
