<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'room_no',
        'status',
    ];

    /**
     * Get all of the hospitals for the Room
     */
    public function hospitals(): HasMany
    {
        return $this->hasMany(Hospital::class, 'room_id', 'id');
    }
}
