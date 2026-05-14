<?php

namespace App\Concerns;

use App\Models\User;
use App\Observers\AuditableObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Adds Blameable behaviour (created_by / updated_by / deleted_by) to
 * a model. Pair with the `SoftDeletes` trait to get the deleted_by
 * stamp on delete.
 *
 * ISO 9001:2015 §7.5.3.2 requires that controlled documents (records)
 * be attributable — every change must be traceable to a named user.
 */
trait HasAuditColumns
{
    public static function bootHasAuditColumns(): void
    {
        static::observe(AuditableObserver::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
