<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Company extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id',
    'name',
    'description',
    'type',
    'address',
    'phone_number',
    'created_at',
  ];

  protected $appends = [
    'created_at_fe',
  ];

  public function getCreatedAtFeAttribute()
  {
      return $this->created_at->toDateString();
  }

  /**
   * Get all of the categories for the Company
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function categories(): HasMany
  {
    return $this->hasMany(Category::class);
  }

  public function users(): HasMany
  {
    return $this->hasMany(User::class);
  }
}
