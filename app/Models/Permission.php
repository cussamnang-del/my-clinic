<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

  // protected function serializeDate(DateTimeInterface $date)
  // {
  //   return $date->format('Y-m-d H:i:s');
  // }

}
