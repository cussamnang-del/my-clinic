<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hospital extends Model
{
    use HasAuditColumns;
    use IsLoggable;
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'document_id',
        'room_id',
        'h_date',
        'h_note',
        'status',
    ];

    /**
     * Get the room that owns the Hospital
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    // protected function serializeDate(\DateTimeInterface $date)
    // {
    //   return $date->format('Y-m-d H:i:s');
    // }
}
