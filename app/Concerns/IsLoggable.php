<?php

namespace App\Concerns;

use App\Observers\LoggableObserver;

/**
 * Records every create / update / delete / restore on a model into
 * the `activity_logs` table via App\Services\ActivityLogService.
 *
 * Models that mix this in get an automatic before/after field diff,
 * with the redaction rules defined in ActivityLogService::redact().
 *
 * Override `$logIgnoreFields` to skip noisy non-clinical columns
 * (e.g. cached counters, generated thumbnails).
 */
trait IsLoggable
{
    public static function bootIsLoggable(): void
    {
        static::observe(LoggableObserver::class);
    }

    /**
     * Columns whose changes should not be written to activity_logs.
     * Defaults to the usual timestamp + Blameable bookkeeping columns.
     */
    public function logIgnoreFields(): array
    {
        return array_merge([
            'updated_at',
            'created_at',
            'deleted_at',
            'created_by',
            'updated_by',
            'deleted_by',
            'remember_token',
        ], property_exists($this, 'logIgnoreFields') && is_array($this->logIgnoreFields)
            ? $this->logIgnoreFields
            : []);
    }
}
