<?php

declare(strict_types=1);

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

use Illuminate\Support\Collection;
use Money\Money;

test('to Array', function () {
    $order = Order::factory()->create()->fresh();

    expect(array_keys($order->toArray()))->toEqual([
        'id',
        'user_id',
        'stripe_checkout_session_id',
        'amount_shipping',
        'amount_discount',
        'amount_tax',
        'amount_subtotal',
        'amount_total',
        'shipping_address',
        'billing_address',
        'created_at',
        'updated_at',
    ]);
});

test('relationships', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create([
        'user_id' => $user->id,
    ]);

    OrderItem::factory()->count(3)->create([
        'order_id' => $order->id,
    ]);

    expect($order->user)->toBeInstanceOf(User::class)
        ->and($order->items)->toBeInstanceOf(EloquentCollection::class)
        ->and($order->items)->toContainOnlyInstancesOf(OrderItem::class)
        ->and($order->items)->toHaveCount(3);
});

test('order money casts', function () {
    $order = Order::factory()->create();

    expect($order->amount_shipping)->toBeInstanceOf(Money::class)
        ->and($order->amount_discount)->toBeInstanceOf(Money::class)
        ->and($order->amount_tax)->toBeInstanceOf(Money::class)
        ->and($order->amount_subtotal)->toBeInstanceOf(Money::class)
        ->and($order->amount_total)->toBeInstanceOf(Money::class);
});

test('order address casts', function () {
    $order = Order::factory()->create();

    expect($order->shipping_address)->toBeInstanceOf(Collection::class)
        ->and($order->billing_address)->toBeInstanceOf(Collection::class);
});
