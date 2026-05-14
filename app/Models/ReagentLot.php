<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ReagentLot extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'received_at' => 'date',
        'opened_at' => 'date',
        'expires_at' => 'date',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * The reagent's shelf life has expired (regardless of whether it's been opened).
     */
    public function isShelfExpired(?Carbon $asOf = null): bool
    {
        $asOf ??= Carbon::now();

        return $this->expires_at !== null && $this->expires_at->lt($asOf->startOfDay());
    }

    /**
     * Once opened, many reagents have a shorter in-use stability window.
     * `open_use_days_allowed` defines that window; before opening, the in-use
     * clock hasn't started so we return false.
     */
    public function isInUseExpired(?Carbon $asOf = null): bool
    {
        $asOf ??= Carbon::now();

        if ($this->opened_at === null || $this->open_use_days_allowed === null) {
            return false;
        }

        return $this->opened_at
            ->copy()
            ->addDays((int) $this->open_use_days_allowed)
            ->lt($asOf->startOfDay());
    }

    public function isUsable(?Carbon $asOf = null): bool
    {
        return ! $this->isShelfExpired($asOf)
            && ! $this->isInUseExpired($asOf)
            && in_array($this->status, ['received', 'in_use'], true);
    }
}
