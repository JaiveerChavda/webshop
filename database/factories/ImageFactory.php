<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => $this->faker->unique()->randomElement(array: [
                'media/blanket.webp',
                'media/cap_2.webp',
                'media/cap.webp',
                'media/mug.webp',
                'media/sweater.webp',
                'media/tshirt-light-pink.webp',
                'media/example_1.webp',
                'media/example_2.webp',
                'media/example_3.webp',
                'media/example_4.webp',
                'media/example_5.webp',
                'media/example_6.webp',
            ]),
        ];
    }
}
