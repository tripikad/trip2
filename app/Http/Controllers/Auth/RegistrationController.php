<?php

namespace App\Http\Controllers\Auth;

use Log;
use Hash;
use Mail;
use App\User;
use Honeypot;
use App\NewsletterType;
use Illuminate\Http\Request;
use App\Mail\ConfirmRegistration;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NewsletterController;

class RegistrationController extends Controller
{
    public function form()
    {
        //return view('pages.auth.register');

        return layout('One')
      ->cached(false)
      ->with('color', 'gray')
      ->with('background', component('BackgroundMap'))
      ->with('header', region('StaticHeader'))
      ->with(
        'top',
        collect()
          ->push(
            component('Title')
              ->is('center')
              ->is('large')
              ->with('title', trans('auth.register.title'))
          )
          ->push('&nbsp;')
          ->push(
            component('Title')
              ->is('center')
              ->is('small')
              ->with('title', trans('auth.register.subhead.title'))
          )
      )
      ->with(
        'content_top',
        component('Grid3')->with(
          'items',
          collect()
            ->push(component('AuthTab')->with('title', 'E-mailiga'))
            ->push(
              component('AuthTab')
                ->is('facebook')
                ->with('route', route('facebook.redirect'))
                ->with('title', 'Facebook')
            )
            ->push(
              component('AuthTab')
                ->is('google')
                ->with('route', route('google.redirect'))
                ->with('title', 'Google')
            )
        )
      )
      ->with(
        'content',
        collect()->push(
          component('Form')
            ->with('route', route('register.submit'))
            ->with(
              'fields',
              collect()
                ->push(Honeypot::generate('full_name', 'time'))
                ->push(
                  component('FormTextfield')
                    ->is('large')
                    ->with('title', trans('auth.register.field.name.title'))
                    ->with('name', 'name')
                )
                ->push(
                  component('FormTextfield')
                    ->is('large')
                    ->with('title', trans('auth.register.field.email.title'))
                    ->with('name', 'email')
                )
                ->push(
                  component('FormPassword')
                    ->is('large')
                    ->with('title', trans('auth.register.field.password.title'))
                    ->with('name', 'password')
                )
                ->push(
                  component('FormPassword')
                    ->is('large')
                    ->with('title', trans('auth.register.field.password_confirmation.title'))
                    ->with('name', 'password_confirmation')
                )
                ->push(
                  component('FormButton')
                    ->is('wide')
                    ->is('large')
                    ->with('title', trans('auth.register.submit.title'))
                )
            )
        )
      )
      ->with(
        'bottom',
        collect()->push(
          component('MetaLink')->with(
            'title',
            trans('auth.register.field.eula.title', [
              'link' => format_link(route('static.show.id', [25151]), trans('auth.register.field.eula.title.link'))
            ])
          )
        )
      )
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
      'full_name' => 'honeypot',
      'time' => 'required|honeytime:3'
    ]);

        $fields = [
      'role' => 'regular',
      'password' => Hash::make($request->get('password'))
    ];

        $user = User::create(array_merge($request->all(), $fields));

        Mail::to($user->email, $user->name)->queue(new ConfirmRegistration($user));

        Log::info('New user registered', [
      'name' => $user->name,
      'link' => route('user.show', [$user])
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
      'name' => $user->name,
      'link' => route('user.show', [$user])
    ]);

        $weekly_newsletter = NewsletterType::where('type', 'weekly')
      ->where('active', 1)
      ->first();

        // @todo Avoid direct controller method call

        if ($weekly_newsletter) {
            (new NewsletterController())->subscribe(request(), $weekly_newsletter->id, $user, true);
        }

        return redirect()
      ->route('login.form')
      ->with('info', trans('auth.register.confirmed.info'));
    }
}
