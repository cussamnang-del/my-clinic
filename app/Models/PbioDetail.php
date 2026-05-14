<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PbioDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the pbio that owns the PbioDetail
     */
    public function pbio(): BelongsTo
    {
        return $this->belongsTo(Pbio::class, 'pbio_id', 'id');
    }

    /**
     * Get the item that owns the PbioDetail
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
