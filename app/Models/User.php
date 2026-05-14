<?php

namespace App\Models;

use App\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
  use SoftDeletes;

  public $table = 'users';

  // protected $appends = ['fullname'];
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'username',
    'phone_no',
    'email',
    'position',
    'email_verified_at',
    'password',
    'remember_token',
    'status',
    'profile_image',
    'created_at',
    'updated_at',
    'deleted_at',
];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
      'password',
      'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
      'email_verified_at' => 'datetime',
  ];

  protected $dates = [
    'email_verified_at',
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  public $orderable = [
      'id',
      'name',
      'email',
      'email_verified_at',
  ];

  public $filterable = [
      'id',
      'name',
      'email',
      'email_verified_at',
      'roles.title',
  ];

  public function getIsAdminAttribute()
  {
    return $this->roles()->where('id', 1)->exists();
  }

  public function setPasswordAttribute($input)
  {
    if ($input) {
      $this->attributes['password'] = Hash::needsRehash($input) ? Hash::make($input) : $input;
    }
  }

  public function roles()
  {
    return $this->belongsToMany(Role::class);
  }

  // public function role()
  // {
  //   return $this->belongsTo(Role::class);
  // }
  // public function getFullNameAttribute()
  // {
  //   return $this->name.' '.$this->username;
  // }
}
