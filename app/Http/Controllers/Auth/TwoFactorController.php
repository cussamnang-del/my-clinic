<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Drives the Two-Factor Authentication setup + challenge flow.
 *
 * Routes:
 *   GET  /two-factor/setup      → showSetup()      (QR + recovery codes)
 *   POST /two-factor/confirm    → confirmSetup()   (verify QR code)
 *   GET  /two-factor/challenge  → showChallenge()  (login-time prompt)
 *   POST /two-factor/verify     → verifyChallenge()
 *   POST /two-factor/disable    → disable()        (re-prompts password)
 */
class TwoFactorController extends Controller
{
    public function __construct(protected TwoFactorService $tfa) {}

    public function showSetup(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        abort_unless($user, 403);

        // Already set up → bounce back to the home page.
        if ($user->hasTwoFactorEnabled()) {
            return redirect()->route('home');
        }

        // Generate a fresh secret + recovery codes if the user is on this
        // page for the first time, otherwise reuse the staged ones.
        if (empty($user->two_factor_secret)) {
            $secret = $this->tfa->generateSecret();
            $recovery = $this->tfa->generateRecoveryCodes();
            $user->two_factor_secret = $secret;
            $user->two_factor_recovery_codes = $recovery['hashed'];
            $user->save();
            $request->session()->put('two_factor.recovery_plain', $recovery['plain']);
        }

        return view('auth.two-factor.setup', [
            'qrCodeDataUri' => $this->tfa->qrCodeDataUri($user, $user->two_factor_secret),
            'secret' => $user->two_factor_secret,
            'recoveryCodes' => $request->session()->get('two_factor.recovery_plain', []),
        ]);
    }

    public function confirmSetup(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = $request->user();
        abort_unless($user, 403);

        if (! $this->tfa->verify($user, $request->input('code'))) {
            return back()->withErrors(['code' => __('Invalid authentication code, please try again.')]);
        }

        $user->two_factor_confirmed_at = now();
        $user->save();

        $request->session()->put('two_factor.passed', true);
        $request->session()->forget('two_factor.recovery_plain');

        return redirect()->route('home')->with('success', __('Two-factor authentication enabled.'));
    }

    public function showChallenge(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        abort_unless($user, 403);

        if (! $user->hasTwoFactorEnabled()) {
            return redirect()->route('two-factor.setup');
        }

        return view('auth.two-factor.challenge');
    }

    public function verifyChallenge(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['nullable', 'digits:6'],
            'recovery_code' => ['nullable', 'string', 'max:32'],
        ]);

        $user = $request->user();
        abort_unless($user, 403);

        $code = (string) $request->input('code', '');
        $recoveryCode = (string) $request->input('recovery_code', '');

        if ($code !== '' && $this->tfa->verify($user, $code)) {
            $request->session()->put('two_factor.passed', true);

            return redirect()->intended(route('home'));
        }

        if ($recoveryCode !== '' && $this->tfa->useRecoveryCode($user, $recoveryCode)) {
            $request->session()->put('two_factor.passed', true);

            return redirect()->intended(route('home'))->with(
                'warning',
                __('A recovery code was used. Please regenerate your 2FA setup.'),
            );
        }

        return back()->withErrors(['code' => __('Invalid authentication or recovery code.')]);
    }

    public function disable(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        abort_unless($user, 403);

        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        $request->session()->forget('two_factor.passed');

        return redirect()->route('home')->with('success', __('Two-factor authentication disabled.'));
    }
}
