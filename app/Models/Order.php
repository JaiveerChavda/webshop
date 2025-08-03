<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected function casts()
    {
        return [
            'shipping_address' => 'collection',
            'billing_address' => 'collection',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
