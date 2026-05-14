<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SopRevision extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'effective_at' => 'datetime',
        'superseded_at' => 'datetime',
    ];

    public function sopDocument(): BelongsTo
    {
        return $this->belongsTo(SopDocument::class);
    }

    public function acknowledgements(): HasMany
    {
        return $this->hasMany(SopAcknowledgement::class);
    }

    public function isEffective(): bool
    {
        return $this->status === 'effective';
    }
}
