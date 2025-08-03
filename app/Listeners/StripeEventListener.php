<?php

namespace App\Listeners;

use App\Actions\WebShop\StripeCheckoutSessionCompleted;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookHandled;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            info('checkout session completed');
            (new StripeCheckoutSessionCompleted)->handle($event->payload['data']['object']['id']);
        }
    }
}
