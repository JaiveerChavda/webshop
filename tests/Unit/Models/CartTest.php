<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Money\Money;

test('to Array', function () {
    $cart = Cart::factory()->create()->fresh();

    expect(array_keys($cart->toArray()))->toEqual([
        'id',
        'user_id',
        'session_id',
        'created_at',
        'updated_at',
    ]);
});

test('relationships', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->forUser($user)->create();

    CartItem::factory()->count(3)->create([
        'cart_id' => $cart->id,
    ]);

    expect($cart->user)->toBeInstanceOf(User::class)
        ->and($cart->items)->toBeInstanceOf(Collection::class)
        ->and($cart->items)->toContainOnlyInstancesOf(CartItem::class)
        ->and($cart->items)->toHaveCount(3);
});

test('cart total is money object', function () {
    $cart = Cart::factory()->create();

    expect($cart->total)->toBeInstanceOf(Money::class);
});
