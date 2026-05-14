<?php

namespace App\Services;

use App\Models\User;
use BaconQrCode\Renderer\GDLibRenderer;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

/**
 * Two-Factor Authentication helper service.
 *
 * Wraps the `pragmarx/google2fa` library so the rest of the application
 * can deal with simple verbs:
 *
 *   $svc->generateSecret()
 *   $svc->qrCodeDataUri($user, $secret)
 *   $svc->verify($user, $code)
 *   $svc->generateRecoveryCodes()
 *   $svc->useRecoveryCode($user, $code)
 *
 * Maps to:
 *   - docs/audit-report.md → H-2 "No 2FA / MFA"
 *   - ISO 27001:2022 Annex A 5.17 (Authentication information)
 *   - NIST SP 800-63B §5.1.4 (Multi-factor OTP)
 */
class TwoFactorService
{
    protected Google2FA $google2fa;

    public function __construct(?Google2FA $google2fa = null)
    {
        $this->google2fa = $google2fa ?? new Google2FA;
    }

    /**
     * Generate a fresh 32-character base32 TOTP secret.
     */
    public function generateSecret(): string
    {
        return $this->google2fa->generateSecretKey(32);
    }

    /**
     * Render the otpauth:// URL as a PNG data URI suitable for embedding
     * in an <img src="..."> tag.
     *
     * We deliberately use the GDLibRenderer (rather than the SVG /
     * ImagickRenderer) so the only runtime dependency is the
     * already-required `ext-gd` from Laravel.
     */
    public function qrCodeDataUri(User $user, string $secret): string
    {
        $issuer = (string) config('security.two_factor.issuer', config('app.name', 'Laravel'));
        $otpUrl = $this->google2fa->getQRCodeUrl(
            $issuer,
            (string) $user->email,
            $secret,
        );

        $writer = new Writer(new GDLibRenderer(280));

        return 'data:image/png;base64,'.base64_encode(
            $writer->writeString($otpUrl)
        );
    }

    /**
     * Verify a 6-digit TOTP code against the user's secret with a ±1 step
     * window (so a code generated 30 s ago is still acceptable).
     */
    public function verify(User $user, string $code): bool
    {
        $secret = $user->two_factor_secret;
        if (empty($secret)) {
            return false;
        }

        // generate window=1 → accept (previous, current, next) 30-second window
        return (bool) $this->google2fa->verifyKey($secret, $code, 1);
    }

    /**
     * Generate N one-time recovery codes (default from config).
     *
     * @return array{plain: string[], hashed: string[]}
     */
    public function generateRecoveryCodes(): array
    {
        $count = (int) config('security.two_factor.recovery_code_count', 8);

        $plain = [];
        $hashed = [];
        for ($i = 0; $i < $count; $i++) {
            $code = strtoupper(Str::random(10));
            $plain[] = $code;
            $hashed[] = Hash::make($code);
        }

        return ['plain' => $plain, 'hashed' => $hashed];
    }

    /**
     * Attempt to spend one of the user's recovery codes. Returns true on
     * success and atomically removes the code from the user's pool.
     */
    public function useRecoveryCode(User $user, string $code): bool
    {
        $code = strtoupper(trim($code));
        $codes = (array) ($user->two_factor_recovery_codes ?? []);

        foreach ($codes as $index => $hash) {
            if (Hash::check($code, $hash)) {
                unset($codes[$index]);
                $user->two_factor_recovery_codes = array_values($codes);
                $user->save();

                return true;
            }
        }

        return false;
    }
}
