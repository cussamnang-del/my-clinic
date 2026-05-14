<?php

namespace Tests\Feature;

use Illuminate\Cache\RateLimiter;
use Tests\TestCase;

/**
 * The Phase 1 RouteServiceProvider registers four named rate limiters
 * (login / public / admin / api). This test guards against an accidental
 * regression that drops one of them.
 */
class RateLimiterRegistrationTest extends TestCase
{
    public function test_named_rate_limiters_are_registered(): void
    {
        $limiter = app(RateLimiter::class);

        foreach (['login', 'public', 'admin', 'api'] as $name) {
            $this->assertNotNull(
                $limiter->limiter($name),
                "Rate limiter '{$name}' was not registered."
            );
        }
    }
}
