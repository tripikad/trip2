<?php

namespace App\Http\Controllers\Auth;

use Log;
use Hash;
use Mail;
use Honeypot;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    public function form()
    {
        //return view('pages.auth.register');

        return layout('1colnarrow')
            ->cached(false)
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))
            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('auth.register.title'))
                )
                ->push('&nbsp;')
                ->push(component('Title')
                    ->is('center')
                    ->is('small')
                    ->with('title', trans('auth.register.subhead.title'))
                )
            )
            ->with('content_top', component('Grid3')->with('items', collect()
                ->push(component('AuthTab')
                    ->with('title', 'E-mailiga')
                )
                ->push(component('AuthTab')
                    ->is('facebook')
                    ->with('route', route('facebook.redirect'))
                    ->with('title', 'Facebook')
                )
                ->push(component('AuthTab')
                    ->is('google')
                    ->with('route', route('google.redirect'))
                    ->with('title', 'Google')
                )
            ))
            ->with('content', collect()
                ->push(component('Form')->with('fields', collect()
                    ->push(Honeypot::generate('full_name', 'time'))
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', trans('auth.register.field.name.title'))
                        ->with('name', 'name')
                    )
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', trans('auth.register.field.email.title'))
                        ->with('name', 'email')
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', trans('auth.register.field.password.title'))
                        ->with('name', 'password')
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', trans('auth.register.field.password_confirmation.title'))
                        ->with('name', 'password_confirmation')
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->is('large')
                        ->with('title', trans('auth.register.submit.title'))
                    )
                ))
            )
            ->with('bottom', collect()->push(component('MetaLink')
                ->with('title', trans('auth.register.field.eula.title', [
                    'link' => format_link(
                        route('static.show.id', [25151]),
                        trans('auth.register.field.eula.title.link')
                    ),
                ]))
            ))
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:64|unique:users',
            'email' => 'required|email|max:64|unique:users',
            'password' => 'required|confirmed|min:6',
            'eula' => 'boolean',
            'full_name'   => 'honeypot',
            'time'   => 'required|honeytime:3',
        ]);

        $fields = [
            'role' => 'regular',
            'password' => Hash::make($request->get('password')),
        ];

        $user = User::create(array_merge($request->all(), $fields));

        Mail::send('email.auth.register', ['user' => $user], function ($mail) use ($user) {
            $mail->to($user->email, $user->name)->subject(trans('auth.register.email.subject'));

            $swiftMessage = $mail->getSwiftMessage();
            $headers = $swiftMessage->getHeaders();

            $header = [
                'category' => [
                    'auth_register',
                ],
                'unique_args' => [
                    'user_id' => (string) $user->id,
                ],
            ];

            $headers->addTextHeader('X-SMTPAPI', format_smtp_header($header));
        });

        Log::info('New user registered', [
            'name' =>  $user->name,
            'link' =>  route('user.show', [$user]),
        ]);

        return redirect()
            ->route('login.form')
            ->with('info', trans('auth.register.sent.info'));
    }

    public function confirm($token)
    {
        $user = User::where('registration_token', $token)->firstOrFail();
        $user->confirmEmail();

        Log::info('New user confirmed registration', [
            'name' =>  $user->name,
            'link' =>  route('user.show', [$user]),
        ]);

        return redirect()
            ->route('login.form')
            ->with('info', trans('auth.register.confirmed.info'));
    }
}
