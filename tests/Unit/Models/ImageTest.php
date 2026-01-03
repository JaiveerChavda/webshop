<?php

declare(strict_types=1);

use App\Models\Image;
use App\Models\Product;

test('to Array', function () {
    $image = Image::factory()->create()->fresh();

    expect(array_keys($image->toArray()))->toEqual([
        'id',
        'product_id',
        'featured',
        'path',
        'created_at',
        'updated_at',
    ]);
});

test('relationships', function () {
    $product = Product::factory()->create();
    
    $image = Image::factory()->create([
        'product_id' => $product->id,
    ]);

    expect($image->product)->toBeInstanceOf(Product::class)
        ->and($image->product->id)->toBe($product->id);
});
