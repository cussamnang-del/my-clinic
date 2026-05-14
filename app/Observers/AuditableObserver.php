<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Stamps the Blameable columns (created_by / updated_by / deleted_by)
 * on a model whose table includes them. Silently no-ops when the
 * column is absent or there is no authenticated user (e.g. console
 * commands and queue workers).
 */
class AuditableObserver
{
    public function creating(Model $model): void
    {
        $userId = $this->currentUserId();
        if ($userId === null) {
            return;
        }

        if (! $model->isDirty('created_by') && $this->hasColumn($model, 'created_by')) {
            $model->created_by = $userId;
        }
        if (! $model->isDirty('updated_by') && $this->hasColumn($model, 'updated_by')) {
            $model->updated_by = $userId;
        }
    }

    public function updating(Model $model): void
    {
        $userId = $this->currentUserId();
        if ($userId === null) {
            return;
        }

        if (! $model->isDirty('updated_by') && $this->hasColumn($model, 'updated_by')) {
            $model->updated_by = $userId;
        }
    }

    public function deleting(Model $model): void
    {
        $userId = $this->currentUserId();
        if ($userId === null) {
            return;
        }

        // Only stamp deleted_by when this is a soft delete; the model
        // is still in the DB at this point so we can update + save it.
        if (
            method_exists($model, 'isForceDeleting')
            && ! $model->isForceDeleting()
            && $this->hasColumn($model, 'deleted_by')
            && ! $model->isDirty('deleted_by')
        ) {
            $model->deleted_by = $userId;
            $model->saveQuietly();
        }
    }

    private function currentUserId(): ?int
    {
        $user = Auth::user();

        return $user?->id;
    }

    private function hasColumn(Model $model, string $column): bool
    {
        // Cheap, allocation-free check that avoids a Schema::hasColumn
        // round-trip on every model touch. The migration adds these
        // columns on a known set of tables, so column-presence is
        // effectively known at boot.
        return in_array($column, $model->getFillable(), true)
            || array_key_exists($column, $model->getAttributes())
            || $model->getConnection()
                ->getSchemaBuilder()
                ->hasColumn($model->getTable(), $column);
    }
}
