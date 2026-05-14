<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

/**
 * Tests for the TOTP wrapper service. We extend Laravel's TestCase so
 * the encrypter / config / hash facades resolve correctly when reading
 * `two_factor_secret` off a freshly built User model.
 */
class TwoFactorServiceTest extends TestCase
{
    private function service(): TwoFactorService
    {
        return new TwoFactorService(new Google2FA);
    }

    public function test_generate_secret_returns_a_base32_string(): void
    {
        $secret = $this->service()->generateSecret();

        $this->assertIsString($secret);
        $this->assertGreaterThanOrEqual(16, strlen($secret));
        $this->assertMatchesRegularExpression('/^[A-Z2-7]+$/', $secret);
    }

    public function test_verify_accepts_a_freshly_generated_code(): void
    {
        $svc = $this->service();
        $secret = $svc->generateSecret();
        $code = (new Google2FA)->getCurrentOtp($secret);

        $user = new User;
        // Setting the cast attribute triggers encryption — that's fine,
        // the getter will round-trip back to plaintext.
        $user->two_factor_secret = $secret;

        $this->assertTrue($svc->verify($user, $code));
    }

    public function test_verify_rejects_an_obviously_wrong_code(): void
    {
        $svc = $this->service();
        $secret = $svc->generateSecret();

        $user = new User;
        $user->two_factor_secret = $secret;

        $this->assertFalse($svc->verify($user, '000000'));
    }

    public function test_generate_recovery_codes_returns_paired_arrays(): void
    {
        $codes = $this->service()->generateRecoveryCodes();

        $this->assertArrayHasKey('plain', $codes);
        $this->assertArrayHasKey('hashed', $codes);
        $this->assertCount(count($codes['plain']), $codes['hashed']);
        $this->assertGreaterThan(0, count($codes['plain']));

        // Each hashed code must verify against its plain counterpart.
        foreach ($codes['plain'] as $i => $plain) {
            $this->assertTrue(Hash::check($plain, $codes['hashed'][$i]));
        }
    }
}
