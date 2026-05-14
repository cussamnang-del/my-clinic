<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RxDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the rxdata that owns the RxDetail
     */
    public function rxdata(): BelongsTo
    {
        return $this->belongsTo(Rx::class, 'rx_id', 'id');
    }
}
