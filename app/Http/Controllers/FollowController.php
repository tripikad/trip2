<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use View;

use App\User;

class FollowController extends Controller
{

    public function index($user_id)
    {

        $user = User::with('follows')
            ->findorFail($user_id);
     
        return View::make('pages.follow.index')
            ->with('user', $user)
            ->render();

    }

}