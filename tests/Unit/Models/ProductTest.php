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
    ]);
});

test('relationships', function () {
    $product = Product::factory()
        ->has(ProductVariant::factory()->count(3), 'variants')
        ->has(Image::factory()->count(4), 'images')
        ->create();

    Image::factory()->create([
        'featured' => 1,
        'product_id' => $product->id,
    ]);

     expect($product->variants)->toContainOnlyInstancesOf(ProductVariant::class)
        ->and($product->variants)->toHaveCount(3)->and($product->images)->toBeInstanceOf(Collection::class)->and($product->images)->toContainOnlyInstancesOf(Image::class)->and($product->images)->toHaveCount(5)->and($product->image)->toBeInstanceOf(Image::class);
});

test('product price is money object', function () {
    $product = Product::factory()->create();

    expect($product->price)->toBeInstanceOf(Money::class);
});
