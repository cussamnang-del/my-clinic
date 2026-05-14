<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\PbioDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pbio extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get all of the details for the Pbio
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function details(): HasMany
  {
      return $this->hasMany(PbioDetail::class, 'pbio_id', 'id');
  }

  /**
   * Get the customer that owns the Pbio
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function customer(): BelongsTo
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }

  public function scopeActive($query)
  {
    return $query->where('status',1);
  }
}
