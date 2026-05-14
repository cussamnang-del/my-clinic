<?php

namespace App\Models;

use App\Http\Middleware\AuthGates;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Permission extends Model
{
  use HasFactory;
  use SoftDeletes;

  public $table = 'permissions';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'group',
    'title',
    'status',
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  // public $orderable = [
  //     'id',
  //     'group',
  //     'title',
  // ];

  // public $filterable = [
  //     'id',
  //     'group',
  //     'title',
  // ];

  protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  /**
   * Invalidate the AuthGates permission-map cache whenever a permission
   * is created, updated, deleted or restored. Without this, a freshly
   * granted or revoked permission would not take effect until the cache
   * naturally expired (24h).
   */
  protected static function booted(): void
  {
    $invalidate = static function (): void {
      Cache::forget(AuthGates::CACHE_KEY);
    };

    static::saved($invalidate);
    static::deleted($invalidate);
    static::restored($invalidate);
  }

  // protected function serializeDate(DateTimeInterface $date)
  // {
  //   return $date->format('Y-m-d H:i:s');
  // }
}
