<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Service for writing append-only audit-log rows.
 *
 * Why a service and not just `ActivityLog::create()`?
 *   - Centralised PII / secret redaction.
 *   - Single place to grab the current request's IP + user-agent.
 *   - Easy to mock in tests.
 *   - Lets non-Eloquent code (e.g. a Gate denial) write a log entry
 *     without having to import a particular model.
 */
class ActivityLogService
{
    /**
     * Column names whose values are redacted before being written
     * to `activity_logs.properties`. Matches case-insensitively on
     * substring, so e.g. "password_confirmation" is also covered.
     */
    private array $redactSubstrings = [
        'password',
        'token',
        'secret',
        'two_factor',
        'remember_token',
        'api_key',
    ];

    public function record(
        string $event,
        ?Model $subject = null,
        array $old = [],
        array $new = [],
        ?string $reason = null,
        array $extraProperties = [],
    ): ActivityLog {
        $request = request() instanceof Request ? request() : null;
        $user = Auth::user();

        return ActivityLog::create([
            'event' => $event,
            'subject_type' => $subject ? $subject::class : null,
            'subject_id' => $subject?->getKey(),
            'causer_id' => $user?->id,
            'causer_type' => $user ? $user::class : null,
            'properties' => array_filter([
                'old' => $this->redact($old),
                'new' => $this->redact($new),
                'extra' => $extraProperties ?: null,
            ], fn ($v) => $v !== null),
            'reason' => $reason,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }

    private function redact(array $payload): array
    {
        $redacted = [];

        foreach ($payload as $key => $value) {
            $lowerKey = strtolower((string) $key);
            $shouldRedact = false;

            foreach ($this->redactSubstrings as $needle) {
                if (str_contains($lowerKey, $needle)) {
                    $shouldRedact = true;
                    break;
                }
            }

            if ($shouldRedact) {
                $redacted[$key] = '[redacted]';

                continue;
            }

            $redacted[$key] = is_array($value) ? $this->redact($value) : $value;
        }

        return $redacted;
    }
}
