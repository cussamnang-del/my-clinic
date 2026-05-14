<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Verify the SecurityHeaders middleware (added in Phase 1) is applying
 * the OWASP-recommended headers to every response.
 */
class SecurityHeadersTest extends TestCase
{
    public function test_responses_include_baseline_security_headers(): void
    {
        // Use the login page (a 200 OK) rather than `/` (a redirect) so
        // we are inspecting the post-route-middleware response chain
        // where SecurityHeaders runs.
        $response = $this->get(route('login'));

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Cross-Origin-Opener-Policy', 'same-origin');

        // CSP should be present but its exact value is environment-tunable.
        $this->assertNotEmpty($response->headers->get('Content-Security-Policy'));

        // Permissions-Policy should be present (no precise assertion on contents).
        $this->assertNotEmpty($response->headers->get('Permissions-Policy'));
    }

    public function test_hsts_header_is_not_set_over_plain_http(): void
    {
        // The middleware deliberately skips HSTS over plain HTTP so dev
        // servers don't poison the browser into permanently demanding HTTPS.
        $response = $this->get(route('login'));

        $this->assertNull($response->headers->get('Strict-Transport-Security'));
    }
}
