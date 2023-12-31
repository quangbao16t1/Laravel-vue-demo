<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'password',
    'email_verified_at',
    'address',
    'phone_number',
    'role_id',
    'company_id',
    'api_token'
  ];

  protected $appends =
  [
    'full_name'
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

  public function role(): BelongsTo
  {
    return $this->belongsTo(Role::class, 'role_id');
  }

  /**
   * Get all of the orders for the User
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function orders(): HasMany
  {
    return $this->hasMany(Order::class);
  }

  /**
   * Get the company that owns the User
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function company(): BelongsTo
  {
    return $this->belongsTo(Company::class);
  }

  /**
   * Get the user's full name.
   *
   * @return string
   */
  public function getFullNameAttribute()
  {
    return "{$this->first_name} {$this->last_name}";
  }
}
