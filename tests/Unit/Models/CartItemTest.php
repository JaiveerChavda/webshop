<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Money\Money;

test('to Array', function () {
    $cartItem = CartItem::factory()->create()->fresh();

    expect(array_keys($cartItem->toArray()))->toEqual([
        'id',
        'cart_id',
        'product_variant_id',
        'quantity',
        'created_at',
        'updated_at',
    ]);
});

test('relationships', function () {
    $cart = Cart::factory()->create();
    $productVariant = ProductVariant::factory()->create();
    
    $cartItem = CartItem::factory()->create([
        'cart_id' => $cart->id,
        'product_variant_id' => $productVariant->id,
    ]);

    expect($cartItem->variant)->toBeInstanceOf(ProductVariant::class)
        ->and($cartItem->product)->toBeInstanceOf(Product::class);
});

test('cart item subtotal is money object', function () {
    $cartItem = CartItem::factory()->create();

    expect($cartItem->subtotal)->toBeInstanceOf(Money::class);
});
