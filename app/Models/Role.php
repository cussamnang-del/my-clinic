<?php

namespace App\Models;

use App\Http\Middleware\AuthGates;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  // protected $with = 'permissions';

  public $table = 'roles';

  /**
   * Invalidate the AuthGates permission-map cache whenever a role is
   * created, updated, deleted or restored so a freshly granted /
   * revoked permission takes effect on the next request.
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

  public function permissions()
  {
    return $this->belongsToMany(Permission::class);
  }

  // protected function serializeDate(DateTimeInterface $date)
  // {
  //   return $date->format('Y-m-d H:i:s');
  // }

  public function users()
  {
    return $this->belongsToMany(User::class);
  }
}
