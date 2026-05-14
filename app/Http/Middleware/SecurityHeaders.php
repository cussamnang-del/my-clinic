<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Apply common security headers to every HTTP response.
 *
 * Headers set:
 *   - Content-Security-Policy (loose — tightened in Phase 4)
 *   - Strict-Transport-Security (only when request is HTTPS)
 *   - X-Frame-Options
 *   - X-Content-Type-Options
 *   - Referrer-Policy
 *   - Permissions-Policy
 *   - Cross-Origin-Opener-Policy
 *
 * Maps to:
 *   - OWASP ASVS v4 §14.4 (HTTP security headers)
 *   - ISO 27001:2022 Annex A 8.23 (Web filtering)
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Best-effort header injection — `headers` is a property on Symfony
        // responses; some streamed/binary responses construct it lazily, so
        // we guard with property_exists() rather than method_exists().
        if (! property_exists($response, 'headers') || ! $response->headers) {
            return $response;
        }

        // Always-on headers
        $headers = [
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), payment=()',
            'Cross-Origin-Opener-Policy' => 'same-origin',
        ];

        // Content-Security-Policy — loose enough to not break the existing
        // jQuery/Bootstrap + Vite + inline-script codebase. Tightened in Phase 4.
        $headers['Content-Security-Policy'] = implode('; ', [
            "default-src 'self'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
            "img-src 'self' data: blob:",
            "font-src 'self' data:",
            // 'unsafe-inline' + 'unsafe-eval' are required while inline jQuery
            // handlers are still present in legacy blade templates. Phase 4 will
            // refactor them out and tighten this directive.
            "script-src 'self' 'unsafe-inline' 'unsafe-eval'",
            "style-src 'self' 'unsafe-inline'",
            "connect-src 'self'",
            "object-src 'none'",
        ]);

        // HSTS only over HTTPS, otherwise some browsers warn.
        if ($request->isSecure()) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains';
        }

        foreach ($headers as $key => $value) {
            // Don't overwrite headers an upstream middleware may have already set.
            if (! $response->headers->has($key)) {
                $response->headers->set($key, $value);
            }
        }

        return $response;
    }
}
