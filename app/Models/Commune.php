<?php

namespace App\Models;

use App\Models\Village;
use App\Models\Customer;
use App\Models\District;
use App\Models\Document;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commune extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get all of the villages for the Commune
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function villages(): HasMany
  {
    return $this->hasMany(Village::class, 'commune_id', 'id');
  }

  /**
   * Get the district that owns the Commune
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function district(): BelongsTo
  {
    return $this->belongsTo(District::class, 'district_id', 'id');
  }

  /**
   * Get the province that owns the Commune
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
    return $this->hasManyThrough(Document::class,Customer::class );
  }
}
