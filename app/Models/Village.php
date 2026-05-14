<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the commune that owns the Village
     */
    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'commune_id', 'id');
    }

    /**
     * Get the district that owns the Village
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    /**
     * Get the province that owns the Village
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'village_id', 'id');
    }

    public function documents()
    {
        return $this->hasManyThrough(Document::class, Customer::class);
    }
}
