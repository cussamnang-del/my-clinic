<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RxDetail extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'rx_id',
        'doctor_description_id',
        'user_id',
        'description',
        'result',
    ];

    /**
     * Get the rxdata that owns the RxDetail
     */
    public function rxdata(): BelongsTo
    {
        return $this->belongsTo(Rx::class, 'rx_id', 'id');
    }
}
