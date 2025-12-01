<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_id');
    }

    protected function casts()
    {
        return [
            'price' => MoneyCast::class,
            'amount_tax' => MoneyCast::class,
            'amount_total' => MoneyCast::class,
        ];
    }
}
