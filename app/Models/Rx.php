<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\RxDetail;
use App\Models\RxDocfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rx extends Model
{
    use HasFactory;

    protected $guarded = [];

  /**
   * Get the customer that owns the Rx
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function customer(): BelongsTo
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }

  public function scopePending($query)
  {
    return $query->where('status', 0);
  }
  public function scopeComplete($query)
  {
    return $query->where('status', 1);
  }

  /**
   * Get all of the docfiles for the Rx
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function docfiles(): HasMany
  {
    return $this->hasMany(RxDocfile::class, 'rx_id', 'id');
  }

  /**
   * Get all of the details for the Rx
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function details(): HasMany
  {
      return $this->hasMany(RxDetail::class, 'rx_id', 'id');
  }
}
