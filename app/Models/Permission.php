<?php

namespace App\Models;

use App\Http\Middleware\AuthGates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

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
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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
}
