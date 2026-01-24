<?php

namespace App\Contracts;

interface StripeGateway
{
    public function retrieveCheckoutSession(string $sessionId);
    public function listCheckoutLineItems(string $sessionId);
    public function retrieveProduct(string $productId);
}
