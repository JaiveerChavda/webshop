<?php

namespace App\Actions;

use App\Models\Cart;

class AddProductVariantToCart
{
    public function add($variantId)
    {
        if (auth()->guest()) {
            $cart = Cart::query()->firstOrCreate([
                'session_id' => session()->getId(),
            ]);
        }

        if (auth()->user()) {
            $cart = auth()->user()->cart ?: auth()->user()->cart()->create();
        }

        dd($cart);

    }
}
