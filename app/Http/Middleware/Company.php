<?php

namespace App\Http\Middleware;

use Closure;

class Company
{
  public function handle($request, Closure $next)
  {
    if ($request->user()) {
      if ($request->user()->isCompany() || $request->user()->hasRole('superuser')) {
        return $next($request);
      }
    }
    return abort(401);
  }
}
