<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserActivity
{
  public function handle($request, Closure $next)
  {
    $this->register_user_as_active();

    return $next($request);
  }

  protected function register_user_as_active()
  {
    $user = Auth::user();

    if ($user) {
      $user->update_active_at();
    }
  }
}
