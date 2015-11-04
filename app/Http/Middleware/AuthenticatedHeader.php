<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthenticatedHeader
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        /*
    	* Facebook redirect return somehow Symfony's RedirectResponse, not laravel's RedirectResponse object,
    	* so there's no header function
    	*/
        if (get_class($response) != 'Symfony\Component\HttpFoundation\RedirectResponse') {
            $response->header('X-Authenticated', Auth::check() ? 'true' : 'false');
        }

        return $response;
    }
}
