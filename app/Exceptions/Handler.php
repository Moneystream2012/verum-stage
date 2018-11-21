<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
        TokenMismatchException::class,
    ];


    public function report(Exception $exception)
    {
        if (app()->environment() == 'production' && app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            flash('Your session has expired.', 'danger');

            return redirect()->back();
        }

        return parent::render($request, $exception);
    }

    /**
     * Create a Symfony response for the given exception.
     *
     * @param  \Exception $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        if (config('app.debug')) {
            return $this->renderExceptionWithWhoops($e);
        }

        return parent::convertExceptionToResponse($e);
    }

    /**
     * Render an exception using Whoops.
     *
     * @param  \Exception $e
     *
     * @return \Illuminate\Http\Response
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    protected function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new \Whoops\Run();
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return response()->make(
            $whoops->handleException($e),
            method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
            method_exists($e, 'getHeaders') ? $e->getHeaders() : []
        );
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        flash(trans('auth.sign_before-continuing'), 'danger');

        if ($request->is('administrator', 'administrator/*')) {
            return redirect()->guest(route('administrator.login'));
        }

        return redirect()->guest(route('personal-office.login'));
    }
}
