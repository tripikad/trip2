<?php

namespace App\Http\Controllers\Auth;

use Log;
use Auth;
use Honeypot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function form()
    {
        //return view('pages.auth.login');

        return layout('One')
            ->cached(false)
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))
            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('auth.login.title'))
                )
                ->push('&nbsp;')
                ->push(component('Title')
                    ->is('center')
                    ->is('small')
                    ->with('title', trans('auth.login.not.registered', [
                        'link' => format_link(
                            route('register.form'),
                            trans('auth.login.not.registered.link.title')
                        ),
                    ]))
                )
            )
            ->with('content_top', component('Grid3')->with('items', collect()
                ->push(component('AuthTab')
                    ->with('title', trans('auth.login.field.name.title'))
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
                ->push(component('Form')
                    ->with('route', route('login.submit'))
                    ->with('fields', collect()
                        ->push(Honeypot::generate('full_name', 'time'))
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('auth.login.field.name.title'))
                            ->with('name', 'name')
                        )
                        ->push(component('FormPassword')
                            ->is('large')
                            ->with('title', trans('auth.login.field.password.title'))
                            ->with('name', 'password')
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('auth.login.field.remember.title'))
                            ->with('name', 'remember')
                        )
                        ->push(component('FormHidden')
                            ->with('name', 'eula')
                            ->with('value', 1)
                        )
                        ->push(component('FormButton')
                            ->is('wide')
                            ->is('large')
                            ->with('title', trans('auth.login.submit.title'))
                        )
                ))
            )
            ->with('bottom', collect()->push(component('MetaLink')
                ->with('title', trans('auth.login.forgot.password', [
                    'link' => format_link(
                        route('reset.apply.form'),
                        trans('auth.reset.apply.title.link')
                    ),
                ]))
            ))
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
            'full_name'   => 'honeypot',
            'time'   => 'required|honeytime:2',
        ]);

        if ($this->signIn($request)) {
            Log::info('User logged in', [
                'name' =>  $request->name,
            ]);

            return redirect('/')
                ->with('info', trans('auth.login.login.info'));
        }

        return redirect()
            ->back()
            ->with('info', trans('auth.login.failed.info'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect()
            ->route('login.form')
            ->with('info', trans('auth.login.logout.info'));
    }

    protected function signIn(Request $request)
    {
        return Auth::attempt($this->getCredentials($request), $request->has('remember'));
    }

    protected function getCredentials(Request $request)
    {
        return [
            'name'    => $request->input('name'),
            'password' => $request->input('password'),
            'verified' => true,
        ];
    }
}
