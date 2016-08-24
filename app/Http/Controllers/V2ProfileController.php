<?php

namespace App\Http\Controllers;

use App\User;

class V2ProfileController extends Controller
{
    public function show($id)
    {

        $user = User::findOrFail($id);

        return view('v2.layouts.2col')

            ->with('header', region('ProfileMasthead', $user))
            ->with('footer', region('Footer'));
    }

}
