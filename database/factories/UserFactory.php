<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    private array $pm_types = [
        // Cards
        'card',

        // Wallets
        'apple_pay',
        'google_pay',

        // Bank debits
        'sepa_debit',
        'ach_debit',
        'bacs_debit',

        // Local payments
        'ideal',
        'bancontact',
        'giropay',
        'sofort',

        // BNPL
        'klarna',

        // India
        'upi',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'stripe_id' => 'cus_'.Str::random(14),
            'pm_type' => fake()->randomElement($this->pm_types),
            'pm_last_four' => random_int(1111, 9999),
            'trial_ends_at' => Carbon::now()->addMonth(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
