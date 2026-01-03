<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'stripe_checkout_session_id' => 'cs_test_' . fake()->uuid(),
            'amount_shipping' => fake()->numberBetween(0, 1000),
            'amount_discount' => fake()->numberBetween(0, 500),
            'amount_tax' => fake()->numberBetween(0, 1000),
            'amount_subtotal' => fake()->numberBetween(1000, 10000),
            'amount_total' => fake()->numberBetween(1000, 10000),
            'shipping_address' => [
                'line1' => fake()->streetAddress(),
                'city' => fake()->city(),
                'state' => fake()->state(),
                'postal_code' => fake()->postcode(),
                'country' => fake()->countryCode(),
            ],
            'billing_address' => [
                'line1' => fake()->streetAddress(),
                'city' => fake()->city(),
                'state' => fake()->state(),
                'postal_code' => fake()->postcode(),
                'country' => fake()->countryCode(),
            ],
        ];
    }
}
