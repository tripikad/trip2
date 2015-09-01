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
            'password' => 'required'
        ]);

        if ($this->signIn($request)) {

            return redirect('/')
                ->with('status', trans('auth.login.login.status'))
                ->header('X-Authenticated', true);
        }

        return redirect()
            ->back()
            ->with('status', trans('auth.login.failed.status'));

    }

    public function logout()
    {
        Auth::logout();

        return redirect()
            ->route('frontpage.index')
            ->with('status', trans('auth.login.logout.status'));
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
            'verified' => true
        ];
    }

}