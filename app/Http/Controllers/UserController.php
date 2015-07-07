<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function show($id, $page = null)
    {
        $user = \App\User::findorFail($id);
     
        return \View::make('pages.user.show')
            ->with('user', $user)
            ->render();
    }

    public function showMessages($id)
    {
        $user = \App\User::findorFail($id);
     
        return \View::make('pages.user.message.index')
            ->with('user', $user)
            ->render();
    }

    public function showMessagesWith($id, $user_id_with)
    {
        $user = \App\User::findorFail($id);
        $user_with = \App\User::findorFail($user_id_with);
     
        return \View::make('pages.user.message.with')
            ->with('user', $user)
            ->with('user_with', $user_with)
            ->with('messages', $user->messagesWith($user_id_with))
            ->render();
    }

    public function showFollows($id)
    {
        $user = \App\User::with('follows')
            ->findorFail($id);
     
        return \View::make('pages.user.follow')
            ->with('user', $user)
            ->render();
    }

}
