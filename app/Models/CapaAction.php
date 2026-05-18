<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CapaAction extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'non_conformance_id',
        'action_type',
        'root_cause',
        'action_plan',
        'action_taken',
        'verification_evidence',
        'assignee_id',
        'due_at',
        'status',
        'closed_by',
        'closed_at',
    ];

    protected $casts = [
        'due_at' => 'date',
        'closed_at' => 'datetime',
    ];

    public function nonConformance(): BelongsTo
    {
        return $this->belongsTo(NonConformance::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}
