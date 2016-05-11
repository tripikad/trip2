<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use Hash;
use App\User;

class RegistrationController extends Controller
{
    public function form()
    {
        return view('pages.auth.register');
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:64|unique:users',
            'email' => 'required|email|max:64|unique:users',
            'password' => 'required|confirmed|min:6',
            'eula' => 'required',
        ]);

        $fields = [
            'role' => 'regular',
            'password' => Hash::make($request->get('password')),
        ];

        $user = User::create(array_merge($request->all(), $fields));

        Mail::queue('email.auth.register', ['user' => $user], function ($mail) use ($user) {

            $mail->to($user->email, $user->name)->subject(trans('auth.register.email.subject'));

            $swiftMessage = $mail->getSwiftMessage();
            $headers = $swiftMessage->getHeaders();

            $header = [
                'category' => [
                    'auth_register',
                ],
                'unique_args' => [
                    'user_id' => (string)$user->id,
                ]
            ];

            $headers->addTextHeader('X-SMTPAPI', format_smtp_header($header));

        });

        return redirect()
            ->route('frontpage.index')
            ->with('info', trans('auth.register.sent.info'));
    }

    public function confirm($token)
    {
        User::where('registration_token', $token)->firstOrFail()->confirmEmail();

        return redirect()
            ->route('login.form')
            ->with('info', trans('auth.register.confirmed.info'));
    }
}
