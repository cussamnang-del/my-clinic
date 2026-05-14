<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One row per password a user has ever had.
 *
 * Inserts happen via App\Services\PasswordHistoryService::record() after
 * a successful password change. Reads happen via the PreventPasswordReuse
 * validation rule.
 */
class PasswordHistory extends Model
{
    public $table = 'password_histories';

    // We only insert into this table — never update existing rows.
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'password_hash',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
