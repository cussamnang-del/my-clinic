<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pbio extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'document_id',
        'status',
    ];

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
