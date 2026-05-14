<?php

namespace App\Models;

use App\Models\ItemType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemGroup extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get all of the itemTypes for the ItemGroup
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function itemTypes(): HasMany
  {
      return $this->hasMany(ItemType::class, 'item_group_id', 'id');
  }
}
