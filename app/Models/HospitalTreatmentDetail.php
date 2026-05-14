<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalTreatmentDetail extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

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
