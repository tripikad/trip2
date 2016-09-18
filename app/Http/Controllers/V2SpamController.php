<?php

namespace App\Http\Controllers;

use App\User;
use Request;

class V2SpamController extends Controller
{
    public function index()
    {
        $users = User::take(50)
        ->latest()
        ->get();

        $users = $users->map(function ($user) {
            return component('FormCheckbox')
                    ->with('label', $user->name.' '.$user->email.' '.$user->verified)
                    ->with('name', 'users[]')
                    ->with('value', $user->id);
        })->push(component('FormButton')
            ->with('title', 'submit')
            );

        return view('v2.layouts.1col')

            ->with('content', collect()
                ->push(component('Form')
                    ->with('route', route('utils.spam.submit'))
                    ->with('fields', $users)
                )
            );
    }

    public function submit()
    {
        dump(Request::all());
    }
}
