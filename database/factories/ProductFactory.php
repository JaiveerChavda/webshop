<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(array: ['Laravel T-shirt','Cap','Mug','Blanket','Sweater']),
            'description' => $this->faker->paragraphs(nb: 2,asText:true),
            'price' => $this->faker->numberBetween(500,4500), //price in cents            
        ];
    }
}
