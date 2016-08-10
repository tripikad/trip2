<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
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
        if (config('app.log') == 'syslog') {
            \Log::error($e->getMessage(), [
                'file' => $e->getTrace()[0]['file'],
                'line' => $e->getTrace()[0]['line'],
            ]);
        } else {
            return parent::report($e);
        }
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

        return parent::render($request, $e);
    }
}
