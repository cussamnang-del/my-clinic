<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferenceRange extends Model
{
    use HasAuditColumns;
    use SoftDeletes;

    protected $fillable = [
        'item_id',
        'sex',
        'age_min_days',
        'age_max_days',
        'low_value',
        'high_value',
        'critical_low',
        'critical_high',
        'unit',
        'source',
    ];

    protected $casts = [
        'age_min_days' => 'integer',
        'age_max_days' => 'integer',
        'low_value' => 'decimal:4',
        'high_value' => 'decimal:4',
        'critical_low' => 'decimal:4',
        'critical_high' => 'decimal:4',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
