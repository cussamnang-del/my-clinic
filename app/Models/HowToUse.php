<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HowToUse extends Model
{
    use HasAuditColumns;
    use IsLoggable;
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
