<?php

namespace App\Actions\WebShop;

use App\Factories\CartFactory;
use InvalidArgumentException;

class AddProductVariantToCart
{
    public function add(int $variantId)
    {
        if ($variantId <= 0) {
            throw new InvalidArgumentException(
                'Product variant ID must be greater than zero.'
            );
        }
        $item = CartFactory::make()->items()->firstOrCreate(
            [
                'product_variant_id' => $variantId,
            ],
            [
                'quantity' => 0,
            ]);

        $item->increment('quantity');
    }
}
