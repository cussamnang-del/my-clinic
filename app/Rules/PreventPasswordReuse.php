<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

/**
 * Validation rule: the new password may not match any of the user's
 * last N (default 5) passwords.
 *
 * Usage in a FormRequest:
 *
 *   'password' => ['required', 'confirmed', Password::min(12)..., new PreventPasswordReuse($user)]
 *
 * If $user is null (i.e. creating a brand-new user) the rule is a no-op,
 * because a user with no history obviously cannot reuse a previous
 * password.
 *
 * Maps to:
 *   - docs/audit-report.md → H-9 "No password-reuse prevention"
 *   - NIST SP 800-63B §5.1.1.2
 */
class PreventPasswordReuse implements ValidationRule
{
    public function __construct(protected ?User $user = null) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->user === null || empty($value) || ! is_string($value)) {
            return;
        }

        $depth = (int) config('security.password_history.depth', 5);

        $recentHashes = $this->user->passwordHistories()
            ->limit($depth)
            ->pluck('password_hash');

        foreach ($recentHashes as $hash) {
            if (Hash::check($value, $hash)) {
                $fail(__(
                    'This password matches one of your last :depth passwords. Please choose a different password.',
                    ['depth' => $depth],
                ));

                return;
            }
        }
    }
}
