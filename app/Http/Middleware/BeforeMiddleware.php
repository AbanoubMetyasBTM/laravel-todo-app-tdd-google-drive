<?php


namespace App\Http\Middleware;

use Closure;

class BeforeMiddleware
{
    public function handle($request, Closure $next)
    {
        // Perform action
        dump("BeforeMiddleware");

        return $next($request);
    }
}
