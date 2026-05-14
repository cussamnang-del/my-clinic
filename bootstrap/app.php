<?php

use App\Http\Middleware\AuthGates;
use App\Http\Middleware\EnsureTwoFactorVerified;
use App\Http\Middleware\ForceHttpsInProduction;
use App\Http\Middleware\LanguageSwitcher;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/admin.php',
        ],
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            /*
            |------------------------------------------------------------
            | Named rate limiters
            |------------------------------------------------------------
            |
            | Referenced from routes as `throttle:login`, `throttle:public`,
            | `throttle:admin`, `throttle:api`. See docs/audit-report.md
            | finding H-5 and OWASP ASVS v4 §11.1.
            */

            // Login + password reset.
            RateLimiter::for('login', function (Request $request) {
                $email = (string) $request->input('email', '');

                return [
                    Limit::perMinute(5)->by(strtolower($email).'|'.$request->ip()),
                    Limit::perMinute(20)->by($request->ip()),
                ];
            });

            // Public AJAX endpoints (address pickers, calendar, autocomplete).
            RateLimiter::for('public', function (Request $request) {
                return Limit::perMinute(120)->by($request->ip());
            });

            // Authenticated admin endpoints. Per-user limit is lenient
            // because the document UI fires many AJAX requests per page;
            // the IP limit is a backstop against scripted abuse.
            RateLimiter::for('admin', function (Request $request) {
                return [
                    Limit::perMinute(300)->by(
                        optional($request->user())->id ?: $request->ip()
                    ),
                    Limit::perMinute(600)->by($request->ip()),
                ];
            });

            // Default API limiter (per-user / per-IP).
            RateLimiter::for('api', function (Request $request) {
                return Limit::perMinute(60)->by(
                    optional($request->user())->id ?: $request->ip()
                );
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        /*
        |----------------------------------------------------------------
        | Global middleware
        |----------------------------------------------------------------
        |
        | ForceHttpsInProduction redirects plain HTTP → HTTPS outside
        | `local`/`testing`. SecurityHeaders applies CSP, HSTS, X-Frame
        | etc. to every response.
        |
        | Maps to: audit-report.md → H-3, H-4.
        */
        $middleware->prepend([
            ForceHttpsInProduction::class,
        ]);

        $middleware->append([
            SecurityHeaders::class,
        ]);

        $middleware->web(append: [
            AuthGates::class,
            LanguageSwitcher::class,
        ]);

        /*
        |----------------------------------------------------------------
        | Route middleware aliases
        |----------------------------------------------------------------
        */
        $middleware->alias([
            'two-factor' => EnsureTwoFactorVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
