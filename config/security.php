<?php

/*
|--------------------------------------------------------------------------
| Security configuration
|--------------------------------------------------------------------------
|
| Centralised tuning knobs for the security layer added in Phase 1 / 1b.
| All values are environment-overridable so production deployments can
| tighten them without code changes.
|
| Maps to:
|   - docs/audit-report.md (H-2, H-5, H-7, H-9 findings)
|   - ISO 27001:2022 Annex A 5.17 (Authentication information)
|   - NIST SP 800-63B (Authenticator and Lifecycle Management)
*/

return [
    /*
    |--------------------------------------------------------------------------
    | Two-factor authentication
    |--------------------------------------------------------------------------
    */
    'two_factor' => [
        // When false the EnsureTwoFactorVerified middleware is a no-op,
        // letting operators ramp 2FA in without redeploying. The QR-code
        // setup pages remain reachable so users can opt-in early.
        'enforced' => env('SECURITY_2FA_ENFORCED', true),

        // QR code issuer label shown in the user's authenticator app.
        'issuer' => env('APP_NAME', 'Laravel'),

        // Number of one-time recovery codes generated when a user first
        // configures 2FA. Codes are 10-character base32, stored hashed.
        'recovery_code_count' => 8,
    ],

    /*
    |--------------------------------------------------------------------------
    | Password reuse prevention
    |--------------------------------------------------------------------------
    */
    'password_history' => [
        // How many previous passwords the new password must not match.
        // NIST SP 800-63B does not mandate a value; CIS Benchmarks
        // recommend at least 5.
        'depth' => env('SECURITY_PASSWORD_HISTORY_DEPTH', 5),
    ],
];
