<?php

namespace App\Models;

use App\Models\ItemType;
use App\Models\ItemGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BioDetail extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get the itemGroup that owns the BioDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function itemGroup(): BelongsTo
  {
    return $this->belongsTo(ItemGroup::class);
  }

  /**
   * Get the itemType that owns the BioDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function itemType(): BelongsTo
  {
    return $this->belongsTo(ItemType::class);
  }

  /**
   * Get the item that owns the BioDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  // public function item(): BelongsTo
  // {
  //   return $this->belongsTo(Item::class, 'item_id', 'id');
  // }

  /**
   * Get all of the comments for the BioDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
   */
  public function customer()
  {
    return $this->hasOneThrough(
      Customer::class,
      Bio::class,
      'id', // Foreign key on orders table...
      'id',
      'bio_id',
      'customer_id', // Foreign key on products table...
    );
  }

  /**
   * Get all of the comments for the BioDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
   */
  public function item()
  {
    return $this->hasOneThrough(
      Item::class,
      Bio::class,
      'id', // Foreign key on orders table...
      'id',
      'bio_id',
      'item_id', // Foreign key on products table...
    );
  }

  public function user()
  {
    return $this->hasOneThrough(
      User::class,
      Bio::class,
      'id', // Foreign key on orders table...
      'id',
      'bio_id',
      'user_id', // Foreign key on products table...
    );
  }

  /**
   * Get the bio that owns the BioDetail
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function bio(): BelongsTo
  {
      return $this->belongsTo(Bio::class, 'bio_id', 'id');
  }
}
