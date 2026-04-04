<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BeforeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dump('cosmin-beforeMiddleware');

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        dump('after request is sent to the browser');
    }
}
