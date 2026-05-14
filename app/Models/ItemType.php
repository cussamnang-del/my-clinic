<?php

namespace App\Models;

use App\Models\Item;
use App\Models\ItemGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemType extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get all of the items for the ItemType
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function items(): HasMany
  {
      return $this->hasMany(Item::class, 'item_type_id', 'id');
  }

  /**
   * Get the itemGroup that owns the ItemType
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function itemGroup(): BelongsTo
  {
      return $this->belongsTo(ItemGroup::class, 'item_group_id', 'id');
  }
}
