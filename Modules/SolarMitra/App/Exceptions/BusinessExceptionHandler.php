<?php

namespace Modules\SolarMitra\App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class BusinessExceptionHandler
{
    protected array $skip = [
        AuthenticationException::class,
        ValidationException::class,
        TokenMismatchException::class,
    ];


    public function handle(Throwable $e, Request $request)
    {
        if (! $request->is('business*')) {
            return null;
        }

        if (config('app.debug')) {
            return null; // let Laravel's Whoops-style debug page show, always, in local dev
        }

        foreach ($this->skip as $skipClass) {
            if ($e instanceof $skipClass) {
                return null;
            }
        }

        $status = $e instanceof HttpExceptionInterface
            ? $e->getStatusCode()
            : 500;

        $view = "solarmitra::errors.{$status}";
        $fallback = 'solarmitra::errors.500';

        if (view()->exists($view)) {
            return response()->view($view, ['exception' => $e], $status);
        }

        if (view()->exists($fallback)) {
            return response()->view($fallback, ['exception' => $e], $status);
        }

        return null;
    }
}