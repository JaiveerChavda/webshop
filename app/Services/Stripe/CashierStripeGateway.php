<?php

namespace App\Services\Stripe;

use App\Contracts\StripeGateway;
use Laravel\Cashier\Cashier;

class CashierStripeGateway implements StripeGateway
{
    public function retrieveCheckoutSession(string $sessionId)
    {
        return Cashier::stripe()->checkout->sessions->retrieve($sessionId);
    }

    public function listCheckoutLineItems(string $sessionId)
    {
        return Cashier::stripe()->checkout->sessions->allLineItems($sessionId);
    }

    public function retrieveProduct(string $productId)
    {
        return Cashier::stripe()->products->retrieve($productId);
    }
}