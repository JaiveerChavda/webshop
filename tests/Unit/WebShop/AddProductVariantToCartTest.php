<?php

use App\Actions\WebShop\AddProductVariantToCart;
use App\Factories\CartFactory;
use App\Models\Product;
use App\Models\ProductVariant;

it('can add product variant to cart', function () {

    $product = Product::factory()->create(['name' => 'iphone','price' => 10000]);

    $variant = ProductVariant::factory()->create([
        'color' => 'orange',
        'product_id' => $product->id,
    ]);

    $variant2 = ProductVariant::factory()->create([
        'color' => 'blue',
        'product_id' => $product->id,
    ]);

    $cart = CartFactory::make();

    expect($cart->items->count())->toBe(0);
    $this->assertDatabaseEmpty('cart_items');

    (new AddProductVariantToCart())->add($variant->id);
    (new AddProductVariantToCart())->add($variant->id);

    (new AddProductVariantToCart())->add($variant2->id);

    $cart->refresh();

    expect($cart->items->count())->toBe(2)->and($cart->items->first()->quantity)->toBe(2)->and($cart->items->last()->quantity)->toBe(1);
    $this->assertDatabaseCount('cart_items', 2);
});
