<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function show($id)
    {
        $user = \App\User::findorFail($id);
     
        return \View::make('pages.user.show')
            ->with('user', $user)
            ->render();
    }


}
