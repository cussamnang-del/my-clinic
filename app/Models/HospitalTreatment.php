<?php

namespace App\Models;

use App\Models\Product;
use App\Models\HospitalTreatmentDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HospitalTreatment extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get all of the htdetails for the HospitalTreatment
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function htdetails(): HasMany
  {
    return $this->hasMany(HospitalTreatmentDetail::class, 'hospital_treatment_id', 'id');
  }

  /**
   * Get all of the productDetails for the HospitalTreatment
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function product_details(): HasMany
  {
    return $this->hasMany(HospitalTreatmentDetail::class, 'hospital_treatment_product_id', 'product_id');
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
