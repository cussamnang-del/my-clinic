<?php

namespace App\Observers;

use App\Services\ActivityLogService;
use Illuminate\Database\Eloquent\Model;

/**
 * Mirrors every change on a Loggable model into activity_logs.
 *
 * "created"  → no `old` payload, `new` is the model's full attributes.
 * "updated"  → `old` is the changed attributes' original values, `new`
 *              is their new values.
 * "deleted"  → `old` is the model's last-known state, `new` is empty.
 * "restored" → inverse of deleted.
 *
 * Field-level redaction (passwords, tokens, secrets) is performed by
 * ActivityLogService.
 */
class LoggableObserver
{
    public function __construct(private readonly ActivityLogService $logger) {}

    public function created(Model $model): void
    {
        $ignore = $this->ignoredFields($model);

        $this->logger->record(
            event: 'created',
            subject: $model,
            old: [],
            new: collect($model->getAttributes())
                ->except($ignore)
                ->all(),
        );
    }

    public function updated(Model $model): void
    {
        $ignore = $this->ignoredFields($model);

        $changes = collect($model->getChanges())->except($ignore);
        if ($changes->isEmpty()) {
            return;
        }

        $original = collect($model->getRawOriginal())->only($changes->keys()->all());

        $this->logger->record(
            event: 'updated',
            subject: $model,
            old: $original->all(),
            new: $changes->all(),
        );
    }

    public function deleted(Model $model): void
    {
        $ignore = $this->ignoredFields($model);

        $this->logger->record(
            event: method_exists($model, 'isForceDeleting') && $model->isForceDeleting()
                ? 'force_deleted'
                : 'deleted',
            subject: $model,
            old: collect($model->getRawOriginal())->except($ignore)->all(),
            new: [],
        );
    }

    public function restored(Model $model): void
    {
        $ignore = $this->ignoredFields($model);

        $this->logger->record(
            event: 'restored',
            subject: $model,
            old: [],
            new: collect($model->getAttributes())->except($ignore)->all(),
        );
    }

    private function ignoredFields(Model $model): array
    {
        return method_exists($model, 'logIgnoreFields') ? $model->logIgnoreFields() : [];
    }
}
