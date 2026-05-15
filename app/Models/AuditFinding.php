<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditFinding extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'internal_audit_id',
        'finding_type',
        'severity',
        'description',
        'clause_reference',
        'non_conformance_id',
    ];

    public function internalAudit(): BelongsTo
    {
        return $this->belongsTo(InternalAudit::class);
    }

    public function nonConformance(): BelongsTo
    {
        return $this->belongsTo(NonConformance::class);
    }
}
