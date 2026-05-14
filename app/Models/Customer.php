<?php

namespace App\Models;

use App\Models\User;
use App\Models\Document;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected $dates = [
    'dob',
    'register_date',
  ];

  /**
   * Get the user that owns the Customer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'register_by', 'id');
  }

  /**
   * Get the province that owns the Customer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function province(): BelongsTo
  {
    return $this->belongsTo(Province::class, 'province_id', 'id')->withDefault(['name_en'=>null]);
  }

  /**
   * Get the district that owns the Customer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function district(): BelongsTo
  {
    return $this->belongsTo(District::class, 'district_id', 'id')->withDefault(['name_en'=>null]);
  }

  /**
   * Get the commune that owns the Customer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function commune(): BelongsTo
  {
    return $this->belongsTo(Commune::class, 'commune_id', 'id')->withDefault(['name_en'=>null]);
  }

  /**
   * Get the village that owns the Customer
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function village(): BelongsTo
  {
    return $this->belongsTo(Village::class, 'village_id', 'id')->withDefault(['name_en'=>null]);
  }

  /**
   * Get all of the documents for the Customer
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function documents(): HasMany
  {
    return $this->hasMany(Document::class, 'customer_id', 'id');
  }

  public function getAddressAttribute()
  {
    $address = '';
    if($this->province->name_en!=''){
      $address = $this->province->name_en;
    }
    if($this->district->name_en!=''){
      $address = $this->province->name_en .', '. $this->district->name_en;
    }
    if($this->commune->name_en!=''){
      $address = $this->province->name_en .', '. $this->district->name_en .', '. $this->commune->name_en;
    }
    if($this->village->name_en!=''){
      $address = $this->province->name_en .', '. $this->district->name_en .', '. $this->commune->name_en.', '. $this->village->name_en;
    }
    return $address;
  }

  public function setPasswordAttribue($value)
  {
    return Hash::make($value);
  }

  // protected function serializeDate(\DateTimeInterface $date)
  // {
  //   return $date->format('d-m-Y H:i:s');
  // }

}
