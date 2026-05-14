<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Force every authenticated user to step through the 2FA challenge once
 * per session (or to set up 2FA if they have not yet done so).
 *
 * The middleware is a no-op when:
 *   - `config('security.two_factor.enforced')` is false (used during a
 *      ramp-in period or on local development).
 *   - The request is anonymous.
 *   - The request is already on a 2FA setup / challenge / logout route.
 *   - The user has already passed the challenge for this session
 *     (`session('two_factor.passed') === true`).
 *
 * Maps to:
 *   - docs/audit-report.md → H-2 "No 2FA / MFA"
 *   - ISO 27001:2022 Annex A 5.17
 */
class EnsureTwoFactorVerified
{
    /**
     * URI prefixes that must always be reachable without passing 2FA so the
     * user can actually complete the setup / challenge flow.
     *
     * @var string[]
     */
    protected array $exemptPaths = [
        'two-factor',
        'logout',
        'home',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! config('security.two_factor.enforced', true)) {
            return $next($request);
        }

        if (! auth()->check()) {
            return $next($request);
        }

        foreach ($this->exemptPaths as $prefix) {
            if ($request->is($prefix) || $request->is($prefix.'/*')) {
                return $next($request);
            }
        }

        $user = auth()->user();

        // Already passed the challenge this session — let them through.
        if ($request->session()->get('two_factor.passed') === true) {
            return $next($request);
        }

        // No 2FA yet → push them to the setup page.
        if (! $user->hasTwoFactorEnabled()) {
            return redirect()->route('two-factor.setup');
        }

        // 2FA configured but not yet passed in this session → challenge.
        return redirect()->route('two-factor.challenge');
    }
}
