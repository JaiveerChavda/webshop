<?php

use App\Livewire\Auth\Login;
use App\Models\User;
use Livewire\Livewire;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('login');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('login');

    $response->assertHasErrors('email');

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');

    $this->assertGuest();
});

it('login is rate limited after 5 attempts',function(){
    $user = User::factory()->create();

    $component = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password');
    
    for($i = 0; $i < 5; $i++){
        $component->call('login')
        ->assertHasErrors(['email' => __('auth.failed')]);
    }
        
    // 6th attempt → rate limited
    $component->call('login')
        ->assertHasErrors(['email']);

    $this->assertStringContainsString(
    __('auth.throttle', ['seconds' => 59]),
    $component->errors()->first('email')
);
});
