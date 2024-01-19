<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof AuthenticationException) {
            return (new Redirector(App::get('url')))->route('login');
        }

        if ($e instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return (new Redirector(App::get('url')))->route('filament.admin.pages.dashboard');
        }

        if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            if ($e->getStatusCode() === 403) {
                return (new Redirector(App::get('url')))->route('filament.admin.pages.dashboard');
            }
        }

        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return (new Redirector(App::get('url')))->route('filament.admin.pages.dashboard');
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
