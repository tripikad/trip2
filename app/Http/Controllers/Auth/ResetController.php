<?php

namespace App\Http\Controllers\Auth;

use Log;
use Mail;
use App\User;
use Honeypot;
use App\Mail\ResetPassword;
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
        // return view('pages.auth.reset.apply');

        return layout('One')
            ->cached(false)
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))
            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('auth.reset.apply.title'))
                )
                ->push('&nbsp;')
                ->push(component('Title')
                    ->is('center')
                    ->is('small')
                    ->with('title', trans('auth.reset.apply.subtitle'))
                )
            )
            ->with('content', collect()
                ->push(component('Form')
                    ->with('route', route('reset.apply.submit'))
                    ->with('fields', collect()
                        ->push(Honeypot::generate('full_name', 'time'))
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('auth.reset.apply.field.email.title'))
                            ->with('name', 'email')
                        )
                        ->push(component('FormButton')
                            ->is('wide')
                            ->is('large')
                            ->with('title', trans('auth.reset.apply.submit.title'))
                        )
                ))
            )
            ->with('bottom', collect()->push(component('MetaLink')
                ->with('title', trans('auth.reset.login.title', [
                    'link' => format_link(
                        route('login.form'),
                        trans('auth.reset.login.link.title')
                    ),
                ]))
            ))
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function passwordForm($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        // return view('pages.auth.reset.password')->with('token', $token);

        return layout('One')
            ->cached(false)
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))
            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('auth.reset.password.title'))
                )
            )
            ->with('content', collect()
                ->push(component('Form')
                    ->with('route', route('reset.password.submit'))
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('auth.reset.password.field.email.title'))
                            ->with('name', 'email')
                        )
                        ->push(component('FormPassword')
                            ->is('large')
                            ->with('title', trans('auth.reset.password.field.password.title'))
                            ->with('name', 'password')
                        )
                        ->push(component('FormPassword')
                            ->is('large')
                            ->with('title', trans('auth.reset.password.field.password_confirmation.title'))
                            ->with('name', 'password_confirmation')
                        )
                        ->push(component('FormHidden')
                            ->with('name', 'token')
                            ->with('value', $token)
                        )
                        ->push(component('FormButton')
                            ->is('wide')
                            ->is('large')
                            ->with('title', trans('auth.reset.password.submit.title'))
                        )
                ))
            )
            ->with('footer', region('FooterLight'))
            ->render();
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
