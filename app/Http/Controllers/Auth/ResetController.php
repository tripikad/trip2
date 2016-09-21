<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\User;
use Log;
use Mail;

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
            Mail::queue('email.auth.reset', ['user' => $user, 'token' => $user->remember_token], function ($mail) use ($user) {
                $mail->to($user->email, $user->name)->subject(trans('auth.reset.email.subject'));

                $swiftMessage = $mail->getSwiftMessage();
                $headers = $swiftMessage->getHeaders();

                $header = [
                    'category' => [
                        'auth_reset',
                    ],
                    'unique_args' => [
                        'user_id' => (string) $user->id,
                    ],
                ];

                $headers->addTextHeader('X-SMTPAPI', format_smtp_header($header));
            });
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
