<?php

namespace App\Models;

use App\Models\Commune;
use App\Models\Village;
use App\Models\Customer;
use App\Models\District;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get all of the districts for the Province
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function districts(): HasMany
  {
    return $this->hasMany(District::class, 'province_id', 'id');
  }

  public function communes(): HasMany
  {
    return $this->hasMany(Commune::class, 'province_id', 'id');
  }

  public function villages(): HasMany
  {
    return $this->hasMany(Village::class, 'province_id', 'id');
  }

  /**
   * Get all of the customers for the Province
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function customers(): HasMany
  {
      return $this->hasMany(Customer::class, 'province_id', 'id');
  }

  public function documents()
  {
    return $this->hasManyThrough(Document::class,Customer::class );
  }
}
