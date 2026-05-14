<?php

namespace App\Models;

use App\Models\Product;
use App\Models\HospitalTreatment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HospitalTreatmentDetail extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get the hospital_treatment that owns the HospitalTreatmentDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function hospital_treatment(): BelongsTo
  {
    return $this->belongsTo(HospitalTreatment::class, 'hospital_treatment_id', 'id');
  }

  /**
   * Get the product that owns the HospitalTreatmentDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function hospital_product(): BelongsTo
  {
    return $this->belongsTo(HospitalTreatment::class, 'hospital_treatment_product_id', 'product_id');
  }

  /**
   * Get the product that owns the HospitalTreatment
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class, 'product_id', 'id');
  }

}
