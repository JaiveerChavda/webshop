<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected function casts()
    {
        return [
            'shipping_address' => 'collection',
            'billing_address' => 'collection',
            'amount_shipping' => MoneyCast::class,
            'amount_discount' => MoneyCast::class,
            'amount_tax' => MoneyCast::class,
            'amount_subtotal' => MoneyCast::class,
            'amount_total' => MoneyCast::class,
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
