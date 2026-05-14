<?php

namespace App\Services;

use App\Models\PasswordHistory;
use App\Models\User;

/**
 * Maintain the {@see PasswordHistory} ledger so we can prevent reuse of
 * recent passwords.
 *
 * `record()` is called from the user-create / user-edit / password-reset
 * flows AFTER a successful save.
 */
class PasswordHistoryService
{
    /**
     * Append the user's current password hash to the history, then trim
     * older entries so we only keep the configured depth.
     */
    public function record(User $user): void
    {
        if (empty($user->getAttributes()['password'] ?? null)) {
            return;
        }

        PasswordHistory::create([
            'user_id' => $user->id,
            'password_hash' => $user->getAttributes()['password'],
        ]);

        $depth = (int) config('security.password_history.depth', 5);

        $idsToKeep = PasswordHistory::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit($depth)
            ->pluck('id');

        PasswordHistory::where('user_id', $user->id)
            ->whereNotIn('id', $idsToKeep)
            ->delete();
    }
}
