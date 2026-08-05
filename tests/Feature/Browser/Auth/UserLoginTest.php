<?php

use App\Models\User;

it('allows a visitor to login', function () {

    User::factory()->create(['name' => 'jaiveer chavda', 'email' => 'mrjaiveer.dev@gmail.com', 'password' => 'password']);

    visit('/')
        // Open the user menu
        ->click('[data-testid="user-menu-button"]')

        // Click Login
        ->click('Login')

        // Ensure we're on the login page
        ->assertPathIs('/login')
        ->assertSee('Log in to your account')

        // Fill credentials
        ->type('email', 'mrjaiveer.dev@gmail.com')
        ->type('password', 'password')

        // Submit
        ->click('Log in');

});
