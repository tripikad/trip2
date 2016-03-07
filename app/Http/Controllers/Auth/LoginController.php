<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function form()
    {
        return view('pages.auth.login');
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($this->signIn($request)) {
            return redirect('/')
                ->with('info', trans('auth.login.login.info'));
        }

        return redirect()
            ->back()
            ->with('info', trans('auth.login.failed.info'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect()
            ->route('frontpage.index')
            ->with('info', trans('auth.login.logout.info'));
    }

    protected function signIn(Request $request)
    {
        return Auth::attempt($this->getCredentials($request), $request->has('remember'));
    }

    protected function getCredentials(Request $request)
    {
        return [
            'name'    => $request->input('name'),
            'password' => $request->input('password'),
            'verified' => true,
        ];
    }
}
