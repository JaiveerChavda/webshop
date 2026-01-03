<?php

declare(strict_types=1);

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Money\Money;

test('to Array', function () {
    $orderItem = OrderItem::factory()->create()->fresh();

    expect(array_keys($orderItem->toArray()))->toEqual([
        'id',
        'order_id',
        'product_variant_id',
        'name',
        'description',
        'price',
        'quantity',
        'amount_discount',
        'amount_subtotal',
        'amount_tax',
        'amount_total',
        'created_at',
        'updated_at',
    ]);
});

test('relationships', function () {
    $order = Order::factory()->create();
    $productVariant = ProductVariant::factory()->create();
    
    $orderItem = OrderItem::factory()->create([
        'order_id' => $order->id,
        'product_variant_id' => $productVariant->id,
    ]);

    expect($orderItem->order)->toBeInstanceOf(Order::class)
        ->and($orderItem->variant)->toBeInstanceOf(ProductVariant::class);
});

test('order item money casts', function () {
    $orderItem = OrderItem::factory()->create();

    expect($orderItem->price)->toBeInstanceOf(Money::class)
        ->and($orderItem->amount_tax)->toBeInstanceOf(Money::class)
        ->and($orderItem->amount_total)->toBeInstanceOf(Money::class);
});
