<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PbioDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the pbio that owns the PbioDetail
     *
     * @return BelongsTo
     */
    public function pbio(): BelongsTo
    {
        return $this->belongsTo(Pbio::class, 'pbio_id', 'id');
    }

    /**
     * Get the item that owns the PbioDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
