<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class NonConformance extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
        'immediate_action',
        'source',
        'severity',
        'status',
        'reported_by',
        'reported_at',
        'closed_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function capaActions(): HasMany
    {
        return $this->hasMany(CapaAction::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
