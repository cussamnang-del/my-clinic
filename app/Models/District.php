<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the communes for the District
     */
    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class, 'district_id', 'id');
    }

    /**
     * Get all of the villages for the District
     */
    public function villages(): HasMany
    {
        return $this->hasMany(Village::class, 'district_id', 'id');
    }

    /**
     * Get the province that owns the District
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'district_id', 'id');
    }

    public function documents()
    {
        return $this->hasManyThrough(Document::class, Customer::class);
    }
}
