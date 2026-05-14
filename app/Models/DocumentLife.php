<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentLife extends Model
{
  use HasFactory;

  protected $guarded= [];

  /**
   * Get the document that owns the DocumentLife
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function document(): BelongsTo
  {
      return $this->belongsTo(Document::class, 'document_id', 'id');
  }

  /**
   * Get all of the doclifedetail for the DocumentLife
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function doclifedetails(): HasMany
  {
      return $this->hasMany(DocumentLifeDetail::class, 'document_lives_id', 'id');
  }

  /**
   * Get the lifesign that owns the DocumentLife
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function lifesign(): BelongsTo
  {
    return $this->belongsTo(LifeSign::class, 'colfield', 'id');
  }

  /**
   * Get the colType that owns the DocumentLife
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function colType(): BelongsTo
  {
    return $this->belongsTo(LifeSign::class, 'coltype', 'id');
  }

  /**
   * Get the customer that owns the DocumentLife
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function customer(): BelongsTo
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }

  /**
   * Get all of the colFields for the DocumentLife
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function colFields(): HasMany
  {
    return $this->hasMany(DocumentLifeDetail::class, 'colfield', 'colfield')->orderBy('coldate','desc');
  }
}
