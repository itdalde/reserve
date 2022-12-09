<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\User\User;
use App\Notifications\Auth\ConfirmEmail;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;

class ConfirmController extends Controller
{

    /**
     * Confirm user email
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        $data = explode('/',url()->current());
        $confirmCode = end($data);
        $user = User::where('confirmation_code',$confirmCode)->first();
        if($user) {
            $user->confirmed = true;
            $user->save();
        };

//        auth()->login($user);
        return redirect()->intended(app(LoginController::class)->redirectPath());
    }

    public function sendEmail(User $user)
    {
        //create confirmation code
        $user->confirmation_code = Uuid::uuid4();
        $user->save();

        //send email
        $user->notify(new ConfirmEmail());

        return back()->with('status', __('auth.confirm'));
    }
}
