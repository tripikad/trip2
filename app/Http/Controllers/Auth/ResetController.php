<?php

namespace App\Http\Controllers\Auth;

use App\Mail\ResetPassword;
use Log;
use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResetController extends Controller
{
    use ResetsPasswords;

    protected $redirectPath = '/';

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function applyForm()
    {
        return view('pages.auth.reset.apply');
    }

    public function passwordForm($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('pages.auth.reset.password')->with('token', $token);
    }

    public function postEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'full_name'   => 'honeypot',
            'time'   => 'required|honeytime:2',
        ]);

        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::INVALID_USER) {
            Log::info('User tried to reset password, but e-mail was invalid', [
                'email' =>  $request->email,
            ]);

            return redirect()
                ->back()
                ->withErrors(['email' => trans($response)]);
        }

        $user = User::where('email', $request->email)->take(1)->first();

        if ($user) {
            Mail::to($user->email, $user->name)->queue(new ResetPassword($user));
        }

        Log::info('Password reset request has been submitted', [
            'email' =>  $request->email,
        ]);

        //if ($response == Password::RESET_LINK_SENT)
        return redirect()
                ->back()
                ->with('info', trans($response));
    }

    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : trans('auth.reset.email.subject');
    }
}
