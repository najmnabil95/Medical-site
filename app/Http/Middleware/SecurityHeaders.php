<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SecurityHeaders - برمجية وسيطة لحقن رؤوس الأمان القياسية.
 *
 * تُضاف تلقائياً لكل استجابة HTTP لحماية الموقع من هجمات
 * Clickjacking وMIME-Sniffing وXSS وتسريب بيانات المراجع.
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent Clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable XSS Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');

        // Permissions Policy (Restrict sensor/device APIs for privacy)
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        return $response;
    }
}
