<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QcResult extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'analyte',
        'control_name',
        'level',
        'lot_number',
        'equipment_id',
        'value',
        'unit',
        'mean',
        'sd',
        'measured_at',
        'operator_id',
        'status',
        'westgard_flag',
        'notes',
    ];

    protected $casts = [
        'value' => 'decimal:4',
        'mean' => 'decimal:4',
        'sd' => 'decimal:4',
        'measured_at' => 'datetime',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
