<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalCertificate extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected $dates = [
    'created_at',
    'updated_at',
    'date',
    'from_date',
    'to_date'
  ];
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

  // protected function serializeDate(DateTimeInterface $date)
  // {
  //   return $date->format('d-m-Y');
  // }
}
