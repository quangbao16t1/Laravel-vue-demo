<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id',
    'user_id',
    'payment_id',
    'order_date',
    'status',
  ];

  /**
   * Get the user that owns the Order
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user(): BelongsTo
  {
      return $this->belongsTo(User::class);
  }

  /**
   * Get the payment that owns the Order
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function payment(): BelongsTo
  {
      return $this->belongsTo(Payment::class);
  }

  public function orderItems(): HasMany
  {
      return $this->hasMany(OrderItem::class);
  }
}
