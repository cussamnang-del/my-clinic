<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\PreventPasswordReuse;
use App\Services\PasswordHistoryService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Validation rules applied to every password reset request.
     *
     * Enforces:
     *   - NIST SP 800-63B password complexity (min 12 + mixed case + digit + symbol).
     *   - No reuse of the user's last N passwords (App\Rules\PreventPasswordReuse).
     *
     * @return array<string, mixed>
     */
    protected function rules()
    {
        $user = $this->guard()->getProvider()->retrieveByCredentials([
            'email' => request()->input('email'),
        ]);

        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::min(12)
                ->mixedCase()
                ->numbers()
                ->symbols(),
                new PreventPasswordReuse($user instanceof CanResetPassword ? $user : null),
            ],
        ];
    }

    /**
     * Hook into the trait's reset() flow to append the new password to
     * the user's history ledger.
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        app(PasswordHistoryService::class)->record($user);

        event(new PasswordReset($user));
        $this->guard()->login($user);
    }
}
