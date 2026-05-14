<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalTreatmentDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the hospital_treatment that owns the HospitalTreatmentDetail
     */
    public function hospital_treatment(): BelongsTo
    {
        return $this->belongsTo(HospitalTreatment::class, 'hospital_treatment_id', 'id');
    }

    /**
     * Get the product that owns the HospitalTreatmentDetail
     */
    public function hospital_product(): BelongsTo
    {
        return $this->belongsTo(HospitalTreatment::class, 'hospital_treatment_product_id', 'product_id');
    }

    /**
     * Get the product that owns the HospitalTreatment
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
