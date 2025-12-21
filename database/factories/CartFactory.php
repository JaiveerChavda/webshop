<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'session_id' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Cart for authenticated user
     */
    public function forUser(?User $user = null): static
    {
        return $this->state(fn () => [
            'user_id' => $user?->id ?? User::factory(),
            'session_id' => null,
        ]);
    }

    /**
     * Guest cart (no user)
     */
    public function guest(): static
    {
        return $this->state(fn () => [
            'user_id' => null,
            'session_id' => Str::uuid(),
        ]);
    }
}
