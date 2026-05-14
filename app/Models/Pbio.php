<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pbio extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the details for the Pbio
     */
    public function details(): HasMany
    {
        return $this->hasMany(PbioDetail::class, 'pbio_id', 'id');
    }

    /**
     * Get the customer that owns the Pbio
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
