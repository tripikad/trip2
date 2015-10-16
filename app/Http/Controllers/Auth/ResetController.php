<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetController extends Controller
{
    use ResetsPasswords;

    protected $redirectPath = '/';

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function applyForm()
    {
        return view('pages.auth.reset.apply');
    }

    public function passwordForm($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('pages.auth.reset.password')->with('token', $token);
    }
}
