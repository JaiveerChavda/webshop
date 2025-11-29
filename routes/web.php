<?php

use App\Livewire\Cart;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\ShowProduct;
use App\Livewire\StoreFront;
use Illuminate\Support\Facades\Route;
use App\Livewire\CheckoutStatus;

Route::get('/', StoreFront::class)->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/product/{productId}', ShowProduct::class)->name('product.show');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout-status', CheckoutStatus::class)->name('checkout.status');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
