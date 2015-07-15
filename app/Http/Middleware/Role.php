<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {

        if (! $request->user() || ! $request->user()->hasRole($role)) {

            return abort(401);
        
        }

        return $next($request);
    }
}
