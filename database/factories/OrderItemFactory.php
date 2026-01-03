<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::factory(),
            'product_variant_id' => \App\Models\ProductVariant::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(1000, 10000),
            'quantity' => fake()->numberBetween(1, 5),
            'amount_discount' => fake()->numberBetween(0, 500),
            'amount_subtotal' => fake()->numberBetween(1000, 10000),
            'amount_tax' => fake()->numberBetween(0, 1000),
            'amount_total' => fake()->numberBetween(1000, 10000),
        ];
    }
}
