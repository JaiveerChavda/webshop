<?php

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Collection;

test('to Array', function () {
    $productVariant = ProductVariant::factory()->create();

    expect(array_keys($productVariant->toArray()))
    ->toEqual([
        'product_id',
        'color',
        'size',
        'updated_at',
        'created_at',
        'id'
    ]);
});

test('relationships',function(){

    $productVariant = ProductVariant::factory()->create();

    expect($productVariant->product)->toBeInstanceOf(Product::class);
});
