<?php

use App\Livewire\Auth\VerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

test('verified email user can redirected to intended route',function() {
    
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(VerifyEmail::class)
        ->call('sendVerification')
        ->assertRedirect(route('dashboard'));
})->group('verify-email');

test('unverified user receives verification email', function () {
    Notification::fake();

    $user = User::factory()->unverified()->create();
 
    Livewire::actingAs($user)
        ->test(VerifyEmail::class)
        ->call('sendVerification')
        ->assertNoRedirect();

    Notification::assertSentTo($user, \Illuminate\Auth\Notifications\VerifyEmail::class);

})->group('verify-email');

test('user can logout',function(){
    
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(VerifyEmail::class)
        ->call('logout')
        ->assertRedirect(route('home'));
})->group('verify-email');