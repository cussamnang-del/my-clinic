<?php

namespace App\Models;

use App\Models\ItemType;
use App\Models\BioDetail;
use App\Models\ItemGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get the itemType that owns the Item
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function itemType(): BelongsTo
  {
      return $this->belongsTo(ItemType::class, 'item_type_id', 'id');
  }

  /**
   * Get the itemGroup that owns the Item
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function itemGroup(): BelongsTo
  {
    return $this->belongsTo(ItemGroup::class, 'item_group_id', 'id');
  }

  /**
   * Get the bioDetail associated with the Item
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function bioDetail(): HasOne
  {
    return $this->hasOne(BioDetail::class, 'item_id', 'id');
  }
}
