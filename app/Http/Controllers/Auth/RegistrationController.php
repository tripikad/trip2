<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Mail;

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
        ]);

        $fields = ['role' => 'regular'];
        
        $user = User::create(array_merge($request->all(), $fields));

        Mail::send('email.auth.register', ['user' => $user], function ($mail) use ($user) {
            
            $mail->to($user->email, $user->name)->subject(trans('auth.register.email.subject'));
        
        });

        return redirect()
            ->route('frontpage')
            ->with('status', trans('auth.register.sent.status'));
            
    }


    public function confirm($token)
    {
        User::where('registration_token', $token)->firstOrFail()->confirmEmail();

        return redirect()
            ->route('login.form')
            ->with('status', trans('auth.register.confirmed.status'));

    }

}