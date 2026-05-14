<?php

namespace App\Models;

use App\Models\DocumentLife;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentLifeDetail extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get the documentLife that owns the DocumentLifeDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function documentLife(): BelongsTo
  {
    return $this->belongsTo(DocumentLife::class, 'document_lives_id', 'id');
  }

}
