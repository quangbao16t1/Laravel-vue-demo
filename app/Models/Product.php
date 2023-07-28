<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id',
    'category_id',
    'name',
    'description',
    'price',
    'count',
    'picture',
    'status',
  ];

  /**
   * Get the user that owns the Product
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function category(): BelongsTo
  {
      return $this->belongsTo(Category::class, 'category_id');
  }

  /**
   * Get all of the discounts for the Product
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function discounts(): HasMany
  {
      return $this->hasMany(Discount::class);
  }

  public function orderItems(): HasMany
  {
      return $this->hasMany(OrderItem::class);
  }

}
