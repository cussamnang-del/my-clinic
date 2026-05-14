<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Append-only audit log row.
 *
 * Created by App\Services\ActivityLogService — never instantiate or
 * write to this model directly. There is intentionally no `updated_at`:
 * audit rows are immutable per ISO 9001:2015 §7.5.3.
 */
class ActivityLog extends Model
{
    public const UPDATED_AT = null;

    public const CREATED_AT = 'logged_at';

    protected $fillable = [
        'event',
        'subject_type',
        'subject_id',
        'causer_id',
        'causer_type',
        'properties',
        'reason',
        'ip_address',
        'user_agent',
        'logged_at',
    ];

    protected $casts = [
        'properties' => 'array',
        'logged_at' => 'datetime',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    protected function old(): Attribute
    {
        return Attribute::get(fn () => $this->properties['old'] ?? []);
    }

    protected function new(): Attribute
    {
        return Attribute::get(fn () => $this->properties['new'] ?? []);
    }
}
