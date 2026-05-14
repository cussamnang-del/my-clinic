<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Risk extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'next_review_at' => 'date',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    /**
     * Convenience accessor for the colour-band associated with a 1–25 score.
     * Bands follow the standard 5×5 risk-matrix convention.
     */
    public function band(): string
    {
        return match (true) {
            $this->score >= 20 => 'extreme',
            $this->score >= 12 => 'high',
            $this->score >= 6 => 'medium',
            default => 'low',
        };
    }
}
