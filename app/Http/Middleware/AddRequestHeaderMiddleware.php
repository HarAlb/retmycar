<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddRequestHeaderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (preg_match('@^\/?v1@', $request->path())) {
            $request->headers->set('Accept', 'application/json');
        }

        if (preg_match('@^\/?api@', $request->path())) {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
