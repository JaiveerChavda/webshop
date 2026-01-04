<?php

use App\Actions\WebShop\MigrateSessionCartToUser;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;

it('migrate session cart to user', function () {

    $this->assertDatabaseEmpty('carts');

    $sessionCart = Cart::factory()
        ->has(CartItem::factory()->count(2), 'items')
        ->create([
            'session_id' => session()->getId(),
        ]);

    $session_cart_id = $sessionCart->id;

    $this->assertDatabaseCount('carts', 1);

    $user = User::factory()->create();
    $this->actingAs($user);

    $userCart = Cart::factory()
        ->has(CartItem::factory()->count(3), 'items')
        ->create([
            'user_id' => auth()->id(),
        ]);

    $user_cart_id = $userCart->id;

    $this->assertDatabaseCount('carts', 2);

    $userCart = MigrateSessionCartToUser::migrate($sessionCart, $userCart);

    $userCart->refresh();
    expect($userCart->items->count())->toBe(5);

    $this->assertDatabaseCount('carts', 1);

    $this->assertDatabaseMissing('carts', [
        'id' => $session_cart_id,
    ]);

});
