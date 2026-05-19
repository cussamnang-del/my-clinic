<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'ap_date',
        'ap_time',
        'customer_id',
        'user_id',
        'desr',
        'status',
        'start_time',
        'finish_time',
        'color',
    ];

    protected $dates = [
        'ap_date',
        'created_at',
        'updated_at',
    ];

    public const APPOINTMENT_STATUS_RADIO = [
        '1' => 'Pending',
        '2' => 'Processing',
        '3' => 'Complete',
    ];

    /**
     * Get the customer that owns the Schedule
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
