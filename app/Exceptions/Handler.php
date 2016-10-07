<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            abort(404);
        }

        if (! config('app.debug') && ($e instanceof \ErrorException || $e instanceof FatalErrorException || $e instanceof QueryException)) {
            try {
                return response()->view('errors.500', [], 500);
            } catch (Exception $e) {
                echo '<!DOCTYPE html>
                        <html>
                            <head>
                                <meta charset="UTF-8">
                            </head>
                            <body style="padding: 15%;">
                                <h1 style="text-align: center; font-family: Verdana, sans-serif;">Nüüd on küll piinlik...</h1>
                                <p style="text-align: center; font-family: Verdana, sans-serif;">Tegemist on tehnilise tõrkega, mistõttu Sa siia lehele sattusid. Oleme sellest teadlikud ning parandame probleemi võimalikult kiirelt. Proovi mõne aja pärast uuesti.<br><br>
                                <a href="/" style="color: green;">Liigu tagasi Trip.ee avalehele</a></p>
                            </body>
                        </html>';
                exit();
            }
        } else {
            return parent::render($request, $e);
        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
