<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OperativeProtocol extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get the customer that owns the OperativeProtocol
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function customer(): BelongsTo
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }

  /**
   * Get the document that owns the OperativeProtocol
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function document(): BelongsTo
  {
    return $this->belongsTo(Document::class, 'document_id', 'id');
  }
}
