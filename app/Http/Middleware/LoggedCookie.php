<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cookie;

class LoggedCookie
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Proceed if we do not have a redirect

        if (get_class($response) !== 'Symfony\Component\HttpFoundation\RedirectResponse') {
            
            // If user is logged in, send a cookie
            // so HTTP caching reverse proxy can bypass the caching if needed

            if (Auth::check()) {
                $response->withCookie(Cookie::forever('logged', 'true'));

            // If user is not logged in, remove the cookie

            } else {
                $response->withCookie(Cookie::forget('logged'));
            }

        }
        
        return $response;
    }
}
