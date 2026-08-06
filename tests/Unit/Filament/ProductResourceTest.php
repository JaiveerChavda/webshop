<?php

use App\Filament\Resources\Products\Pages\ListProducts;
use App\Models\Product;

use function Pest\Livewire\livewire;

it('can render the product list page', function () {
    // Mount the Livewire component responsible for the page
    livewire(ListProducts::class)
        ->assertSuccessful();
});

it('can render list products with records', function () {
    $products = Product::factory(5)->create();

    livewire(ListProducts::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords($products)
        ->assertCountTableRecords(5);
});

it('can render list products without records', function () {
    livewire(ListProducts::class)
        ->assertCountTableRecords(0);
});

it('can render product list with these columns names,price,order_count', function () {
    livewire(ListProducts::class)
        ->assertCanRenderTableColumn('name')
        ->assertCanRenderTableColumn('price')
        ->assertCanRenderTableColumn('orders_count')
        ->assertCanRenderTableColumn('created_at');
});

it('can search products with name', function () {
    $products = Product::factory(5)->create();

    $name = $products->first()->name;

    livewire(ListProducts::class)
        ->searchTable($name)
        ->assertCanSeeTableRecords($products->where('name', $name))
        ->assertCanNotSeeTableRecords($products->where('name', '!=', $name));
});

it('can sort products by price', function () {
    $products = Product::factory(5)->create();

    $sortedProductsAsc = Product::query()->orderBy('price')->get();
    $sortedProductsDesc = Product::query()->orderBy('price', 'desc')->get();

    livewire(ListProducts::class)
        ->sortTable('price')
        ->assertCanSeeTableRecords($sortedProductsAsc)
        ->sortTable('price', 'desc')
        ->assertCanSeeTableRecords($sortedProductsDesc);

});
