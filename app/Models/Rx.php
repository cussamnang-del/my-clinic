<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rx extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Get the customer that owns the Rx
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function scopeComplete($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Get all of the docfiles for the Rx
     */
    public function docfiles(): HasMany
    {
        return $this->hasMany(RxDocfile::class, 'rx_id', 'id');
    }

    /**
     * Get all of the details for the Rx
     */
    public function details(): HasMany
    {
        return $this->hasMany(RxDetail::class, 'rx_id', 'id');
    }
}
