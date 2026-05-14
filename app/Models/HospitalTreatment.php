<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalTreatment extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Get all of the htdetails for the HospitalTreatment
     */
    public function htdetails(): HasMany
    {
        return $this->hasMany(HospitalTreatmentDetail::class, 'hospital_treatment_id', 'id');
    }

    /**
     * Get all of the productDetails for the HospitalTreatment
     */
    public function product_details(): HasMany
    {
        return $this->hasMany(HospitalTreatmentDetail::class, 'hospital_treatment_product_id', 'product_id');
    }

    /**
     * Get the product that owns the HospitalTreatment
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
