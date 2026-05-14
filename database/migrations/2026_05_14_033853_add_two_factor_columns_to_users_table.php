<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add Two-Factor Authentication (TOTP RFC 6238) columns to the users table.
 *
 *   - two_factor_secret           Base32 TOTP secret, stored encrypted.
 *   - two_factor_recovery_codes   JSON array of bcrypt-hashed one-time
 *                                 codes the user can use to bypass TOTP
 *                                 when their authenticator is lost.
 *   - two_factor_confirmed_at     Set the moment the user successfully
 *                                 verifies the QR code for the first time;
 *                                 also used by EnsureTwoFactorVerified
 *                                 middleware to decide whether to enforce
 *                                 the challenge.
 *
 * Maps to:
 *   - docs/audit-report.md → H-2 "No 2FA / MFA"
 *   - ISO 27001:2022 Annex A 5.17 (Authentication information)
 *   - NIST SP 800-63B §5.1.4 (Multi-factor OTP authenticators)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')->nullable()->after('password');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at',
            ]);
        });
    }
};
