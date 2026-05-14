<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentCalibration extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'calibration_date' => 'date',
        'due_date' => 'date',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
