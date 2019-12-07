<?php

namespace App\Http\Middleware;

use Closure;

class LastPageExceptAuth
{
    public function handle($request, Closure $next)
    {
        if (!request()->ajax()) {
            $this->save_current_page();
        }

        return $next($request);
    }

    protected function save_current_page()
    {
        if (
      !in_array(
        request()
          ->route()
          ->getName(),
        [
          'register.form',
          'register.submit',
          'register.confirm',
          'login.form',
          'login.submit',
          'login.logout',
          'reset.apply.form',
          'reset.apply.submit',
          'reset.password.form',
          'reset.password.submit'
        ]
      )
    ) {
            session([
        'last_active_page' => request()->fullUrl()
      ]);
        }
    }
}
