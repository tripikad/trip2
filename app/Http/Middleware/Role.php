<?php

namespace App\Http\Middleware;

use Closure;

class Role
{

    public function handle($request, Closure $next, $role, $owner = false)
    {

        if (! $request->user() || ! $request->user()->hasRole($role)) {

            return abort(401);
        
        }

        return $next($request);
    }

}
