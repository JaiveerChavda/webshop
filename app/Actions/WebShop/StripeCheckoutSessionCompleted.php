<?php

namespace App\Actions\WebShop;

use App\Models\User;
use Laravel\Cashier\Cashier;

class StripeCheckoutSessionCompleted
{
    public function handle($sessionId)
    {
        $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);
        $user = User::find($session->metadata->user_id);

        info('about user',[
            'user' => $user
        ]);
        
        $order = $user->orders()->create([
            'stripe_checkout_session_id' => $sessionId,
            'amount_shipping' => $session->total_details->amount_shipping,
            'amount_discount' => $session->total_details->amount_discount,
            'amount_tax' => $session->total_details->amount_tax,
            'amount_subtotal' => $session->amount_subtotal,
            'amount_total' => $session->amount_total,
            'shipping_address' => [
                'name' => $session->collected_information->shipping_details->name,
                'city' => $session->collected_information->shipping_details->address->city,
                'country' => $session->collected_information->shipping_details->address->country,
                'line1' => $session->collected_information->shipping_details->address->line1,
                'line2' => $session->collected_information->shipping_details->address->line2,
                'postal_code' => $session->collected_information->shipping_details->address->postal_code,
                'state' => $session->collected_information->shipping_details->address->state,
            ],
            'billing_address' => [
                'name' => $session->customer_details->name,
                'city' => $session->customer_details->address->city,
                'country' => $session->customer_details->address->country,
                'line1' => $session->customer_details->address->line1,
                'line2' => $session->customer_details->address->line2,
                'postal_code' => $session->customer_details->address->postal_code,
                'state' => $session->customer_details->address->state,
            ]
        ]);
    }
}
