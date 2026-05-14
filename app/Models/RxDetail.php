<?php

namespace App\Models;

use App\Models\Rx;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RxDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

      /**
   * Get the rxdata that owns the RxDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function rxdata(): BelongsTo
  {
      return $this->belongsTo(Rx::class, 'rx_id', 'id');
  }
}
