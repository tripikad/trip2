<?php

namespace App\Http\Middleware;

use Closure;

class Role
{

    public function handle($request, Closure $next, $role, $owner = false)
    {

        if ($request->user() && $owner == 'contentowner' && $request->user()->hasRoleOrOwner(
                $role,
                \App\Content::findOrFail($request->id)->user->id
        )) {

            return $next($request);
        
        }

        if ($request->user() && $owner == 'commentowner' && $request->user()->hasRoleOrOwner(
                $role,
                \App\Comment::findOrFail($request->id)->user->id
        )) {

            return $next($request);
        
        }

        if ($request->user() && $owner == 'userowner' && $request->user()->hasRoleOrOwner(
                $role,
                \App\User::findOrFail($request->id)->id
        )) {

            return $next($request);
        
        }

        if ($request->user() && $request->user() && $request->user()->hasRole($role)) {

            return $next($request);
        
        }

        return abort(401);

        
    }

}
