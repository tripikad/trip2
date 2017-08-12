<?php

namespace App\Http\Controllers\Auth;

use App\Mail\ConfirmRegistration;
use Log;
use Hash;
use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'full_name'   => 'honeypot',
            'time'   => 'required|honeytime:3',
        ]);

        $fields = [
            'role' => 'regular',
            'password' => Hash::make($request->get('password')),
        ];

        $user = User::create(array_merge($request->all(), $fields));

        Mail::to($user->email, $user->name)->queue(new ConfirmRegistration($user));

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
