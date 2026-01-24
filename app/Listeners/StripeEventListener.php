<?php

namespace App\Listeners;

use App\Actions\WebShop\StripeCheckoutSessionCompleted;
use App\Contracts\StripeGateway;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            (new StripeCheckoutSessionCompleted(app(StripeGateway::class)))->handle($event->payload['data']['object']['id']);
        }
    }
}
