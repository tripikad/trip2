<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\User;

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

        $user = User::where('email', $request->email)->take(1)->first();

        $response = Password::sendResetLink($request->only('email'), function ($message) use ($user) {
            $message->subject($this->getEmailSubject());

            $swiftMessage = $message->getSwiftMessage();
            $headers = $swiftMessage->getHeaders();

            $header = [
                'category' => [
                    'auth_reset',
                ],
                'unique_args' => [
                    'user_id' => (string) $user->id,
                ],
            ];

            $headers->addTextHeader('X-SMTPAPI', format_smtp_header($header));
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()
                    ->back()
                    ->with('info', trans($response));

            case Password::INVALID_USER:
                return redirect()
                    ->back()
                    ->withErrors(['email' => trans($response)]);
        }
    }
}
