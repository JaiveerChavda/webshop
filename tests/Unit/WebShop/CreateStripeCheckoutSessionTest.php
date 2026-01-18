<?php

use App\Actions\WebShop\AddProductVariantToCart;
use App\Actions\WebShop\CreateStripeCheckoutSession;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Laravel\Cashier\Checkout;

it('create stripe checkout session for a user cart', function () {

    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->has(ProductVariant::factory()->count(2), 'variants')->create();

    (new AddProductVariantToCart)->add($product->variants->first()->id);
    $user->refresh();
    (new AddProductVariantToCart)->add($product->variants->last()->id);

    $cart = $user->refresh()->cart;
    expect($cart)->not()->toBeNull();
    expect($cart->items)->toHaveCount(2);

    $fakeSession = Mockery::mock(Checkout::class);
    $fakeSession->url = 'https://checkout.stripe.test/session/123';

    $mockedUser = Mockery::mock(User::class)->makePartial();
    $mockedUser->id = $user->id;

    $mockedUser->shouldReceive('checkout')
        ->once()
        ->andReturn($fakeSession);

    $cart->setRelation('user', $mockedUser);

    $session = (new CreateStripeCheckoutSession)->createFromCart($cart);

    expect($session)->not()->toBeNull();
    expect($session)->toBeInstanceOf(Checkout::class);
    expect($session->url)->toBeString();
    expect($session->url)->toStartWith('https://');
    expect($session->url)->toContain('checkout.stripe.test');
});
