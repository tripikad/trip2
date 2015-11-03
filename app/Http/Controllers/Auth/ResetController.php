<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()
                    ->route('frontpage.index')
                    ->with('info', trans($response));

            case Password::INVALID_USER:
                return redirect()
                    ->back()
                    ->withErrors(['email' => trans($response)]);
        }
    }
}
