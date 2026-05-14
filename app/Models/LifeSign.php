<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LifeSign extends Model
{
  use HasFactory;

  protected $guarded = [];

  public const TYPES = [
    '1' => 'TypeA',
    '2' => 'TypeB',
  ];

  public function childs()
  {
    return $this->hasMany(LifeSign::class,'type_id','id');
  }
  public function child()
  {
    return $this->belongsTo(LifeSign::class,'type_id','id');
  }

  /**
   * Get all of the doclives for the LifeSign
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function doclives(): HasMany
  {
    return $this->hasMany(DocumentLife::class, 'coltype', 'id');
  }

}
