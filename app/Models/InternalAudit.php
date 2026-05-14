<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternalAudit extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'scheduled_at' => 'date',
        'started_at' => 'date',
        'completed_at' => 'date',
    ];

    public function findings(): HasMany
    {
        return $this->hasMany(AuditFinding::class);
    }

    public function leadAuditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lead_auditor_id');
    }
}
