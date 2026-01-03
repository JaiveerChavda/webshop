<?php

declare(strict_types=1);
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

test('to Array', function () {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toEqual([
        'id',
        'name',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
    ]);

});

test('relationships', function () {
    $user = User::factory()->create();

    Cart::factory()->forUser($user)->create();

    expect($user->cart)->toBeInstanceOf(Cart::class)
        ->and($user->orders)->toBeInstanceOf(Collection::class)->toContainOnlyInstancesOf(Order::class)
        ->and($user->orderItems)->toBeInstanceOf(Collection::class)
        ->and($user->orderItems)->toContainOnlyInstancesOf(OrderItem::class);
});

test('user inital attribute', function () {
    $user = User::factory()->create(['name' => 'Jaiveersingh Chavda']);
    expect($user->initials)->toBeString()->toEqual('JC');
});
