<?php

namespace App\Http\Middleware;

use Closure;

class XssProtection
{

    public function handle($request, Closure $next)
    {
        if (!in_array(strtolower($request->method()), ['put', 'post', 'patch'])) {
            
            return $next($request);
        
        }

        $input = $request->except('body');

        array_walk_recursive($input, function(&$input) {
            
            $input = strip_tags($input);
        
        });

        $request->merge($input);
        
        if ($request->has('body')) {
        
            $request->merge(['body' => strip_tags($request->body, config('site.allowedtags'))]);
        
        }
        
        return $next($request);
    }

}