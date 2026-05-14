<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Equipment extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $table = 'equipment';

    protected $guarded = [];

    protected $casts = [
        'commissioned_at' => 'date',
        'retired_at' => 'date',
        'last_calibrated_at' => 'date',
        'next_calibration_due_at' => 'date',
    ];

    public function calibrations(): HasMany
    {
        return $this->hasMany(EquipmentCalibration::class);
    }

    public function isCalibrationOverdue(?Carbon $asOf = null): bool
    {
        $asOf ??= Carbon::now();

        return $this->next_calibration_due_at !== null
            && $this->next_calibration_due_at->lt($asOf->startOfDay());
    }
}
