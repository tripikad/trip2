<?php

namespace App\Http\Middleware;

use Closure;

class CompanyOwner
{
    public function handle($request, Closure $next)
    {
        if ($request->user()) {
            if ($request->user()->company_id === $request->company->id || $request->user()->hasRole('superuser')) {
                return $next($request);
            }
        }

        return abort(401);
    }
}