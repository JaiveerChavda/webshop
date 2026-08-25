<?php

use App\Models\Product;
use App\Models\ProductVariant;
use Livewire\Volt\Volt;

it('shows all products when no size filter is applied', function () {
    $products = Product::factory()->count(3)->create();

    Volt::test('pages::home')
        ->assertSee($products->pluck('name')->all());
});

it('lists distinct sizes from product variants in the filter', function () {
    Product::factory()
        ->has(ProductVariant::factory()->count(3)->sequence(
            ['size' => 'S'],
            ['size' => 'XL'],
            ['size' => 'XL'],
        ), 'variants')
        ->create();

    $component = Volt::test('pages::home');

    expect($component->instance()->availableSizes->all())->toBe(['S', 'XL']);
});

it('filters products by selected size', function () {
    $xlProduct = Product::factory()->create(['name' => 'XL Hoodie']);
    ProductVariant::factory()->for($xlProduct, 'product')->create(['size' => 'XL']);

    $mProduct = Product::factory()->create(['name' => 'M T-Shirt']);
    ProductVariant::factory()->for($mProduct, 'product')->create(['size' => 'M']);

    Volt::test('pages::home')
        ->set('sizes', ['XL'])
        ->assertSee('XL Hoodie')
        ->assertDontSee('M T-Shirt');
});
