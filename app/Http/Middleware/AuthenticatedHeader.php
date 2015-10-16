<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthenticatedHeader
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('X-Authenticated', Auth::check() ? 'true' : 'false');
    }
}
