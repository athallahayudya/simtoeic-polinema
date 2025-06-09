<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Content Security Policy - Prevent XSS (Disabled for compatibility)
        // Uncomment and adjust as needed for production
        /*
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self' 'unsafe-inline' 'unsafe-eval'; " .
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https: http: data:; " .
                "style-src 'self' 'unsafe-inline' https: http: data:; " .
                "font-src 'self' 'unsafe-inline' https: http: data:; " .
                "img-src 'self' 'unsafe-inline' https: http: data: blob:; " .
                "connect-src 'self' https: http:; " .
                "media-src 'self' https: http: data:; " .
                "object-src 'none'; " .
                "base-uri 'self'; " .
                "form-action 'self';"
        );
        */

        // X-Frame-Options - Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // X-Content-Type-Options - Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-XSS-Protection - Enable XSS filtering
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy - Control referrer information
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Strict Transport Security - Force HTTPS (uncomment for production with HTTPS)
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        return $response;
    }
}
