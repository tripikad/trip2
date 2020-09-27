<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Psy\Exception\FatalErrorException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = ['password', 'password_confirmation'];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $e
     * @return void
     *
     * @throws \Throwable
     */
    public function report(\Throwable $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            abort(404);
        }

        if (strpos(config('app.debug_ips'), ',') !== false) {
            $ips = explode(',', config('app.debug_ips'));
        } else {
            $ips = [];
        }

        if (in_array(request()->ip(), $ips)) {
            Config::set('app.debug', true);
        }

        if (
            !config('app.debug') &&
            ($e instanceof \ErrorException || $e instanceof FatalErrorException || $e instanceof QueryException)
        ) {
            try {
                return response()->view('errors.500', [], 500);
            } catch (Exception $e) {
                echo '<h1 style="width: 40vw; padding: 3rem; font-size: 2em; font-family: sans-serif; color: hsl(0, 79%, 66%);">Tripil on tehnilised probleemid. Oleme varsti tagasi.</h1>';
                exit();
            }
        } else {
            return parent::render($request, $e);
        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  Request  $request
     * @param AuthenticationException $exception
     * @return JsonResponse|RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
