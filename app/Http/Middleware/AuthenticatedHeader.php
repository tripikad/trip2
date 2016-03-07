<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cookie;

class AuthenticatedHeader
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {

            $response->withCookie(Cookie::forever('logged', 'true'));

        } else {
            
            $response->withCookie(Cookie::forget('logged'));
        }

        return $response;
    }
}
