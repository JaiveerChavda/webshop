<?php

namespace App\Actions\WebShop;

use App\Factories\CartFactory;

class AddProductVariantToCart
{
    public function add($variantId)
    {
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
