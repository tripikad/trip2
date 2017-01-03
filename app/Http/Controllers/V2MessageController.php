<?php

namespace App\Http\Controllers;

use App\User;

class V2MessageController extends Controller
{
    public function index($user_id)
    {
        $user = User::findorFail($user_id);
        $messages = collect($user->messages());
        dump($messages);
        return layout('1col')

            ->with('header', region('UserHeader', $user))

            ->with('content', $messages->map(function ($message) {
                return component('Message')->with('title', $message->body);
            }))

            ->with('footer', region('Footer'))

            ->render();
    }

}
