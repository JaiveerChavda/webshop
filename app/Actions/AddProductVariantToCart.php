<?php

namespace App\Actions;

use App\Factories\CartFactory;

class AddProductVariantToCart
{
    public function add($variantId)
    {
        CartFactory::make()->items()->create([
            'product_variant_id' => $variantId,
            'quantity' => 1,
        ]);
    }
}
