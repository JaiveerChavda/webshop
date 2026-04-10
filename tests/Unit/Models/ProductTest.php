<?php

declare(strict_types=1);
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Collection;
use Money\Money;

test('to Array', function () {
    $product = Product::factory()->create()->fresh();

    expect(array_keys($product->toArray()))->toEqual([
        'id',
        'name',
        'description',
        'price',
        'created_at',
        'updated_at',
        'original_image_url',
        'preview_image_url',
        'media',
    ]);
});

test('relationships', function () {
    $product = Product::factory()
        ->has(ProductVariant::factory()->count(3), 'variants')
        ->create();

    expect($product->variants)->toContainOnlyInstancesOf(ProductVariant::class)
        ->and($product->variants)->toHaveCount(3);
});

test('product price is money object', function () {
    $product = Product::factory()->create();

    expect($product->price)->toBeInstanceOf(Money::class);
});
