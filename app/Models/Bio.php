<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bio extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the detail for the Bio
     */
    public function detail(): HasMany
    {
        return $this->hasMany(BioDetail::class, 'bio_id', 'id')->orderBy('bio_date', 'desc');
    }

    /**
     * Get the item that owns the Bio
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    /**
     * Get the customer that owns the Bio
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
