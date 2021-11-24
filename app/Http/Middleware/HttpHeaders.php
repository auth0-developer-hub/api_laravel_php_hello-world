<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->header('X-XSS-Protection', '0');
        $response->header('Strict-Transport-Security', 'max-age=31536000 ; includeSubDomains');
        $response->header('X-Frame-Options', 'deny');
        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('Content-Security-Policy', "default-src 'self'; frame-ancestors 'none';");
        $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', '0');
        $response->header('Content-Type', 'application/json; charset=utf-8');
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');
        return $response;
    }
}
