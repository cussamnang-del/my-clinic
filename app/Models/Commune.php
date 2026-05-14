<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commune extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the villages for the Commune
     */
    public function villages(): HasMany
    {
        return $this->hasMany(Village::class, 'commune_id', 'id');
    }

    /**
     * Get the district that owns the Commune
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    /**
     * Get the province that owns the Commune
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'commune_id', 'id');
    }

    public function documents()
    {
        return $this->hasManyThrough(Document::class, Customer::class);
    }
}
