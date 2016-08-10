<?php

namespace App\Http\Middleware;

use Closure;

class XssProtection
{
    public function handle($request, Closure $next)
    {
        if (! in_array(strtolower($request->method()), ['put', 'post', 'patch'])) {
            return $next($request);
        }

        $input = $request->except('body');

        array_walk_recursive($input, function (&$input) {
            $input = strip_tags($input);
        });

        $request->merge($input);

        if ($request->has('body')) {
            if (! preg_match('#('.implode('|', config('site.allowAllTags')).')#', $request->path())) {
                $request->merge(['body' => strip_tags($request->body, config('site.allowedtags'))]);
            } else {
                $request->merge(['body' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", '', $request->body)))]);
            }
        }

        return $next($request);
    }
}
