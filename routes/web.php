<?php

use App\Livewire\Cart;
use App\Livewire\CheckoutStatus;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\ShowProduct;
use App\Livewire\StoreFront;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', StoreFront::class)->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/product/{productId}', ShowProduct::class)->name('product.show');
Route::get('/cart', Cart::class)->name('cart');

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout-status', CheckoutStatus::class)->name('checkout.status');
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('preview/order-email', function () {
        $order = \App\Models\Order::find(5);

        return new \App\Mail\OrderConfirmation($order);

        // Mail::to($order->user->email)->send(new \App\Mail\OrderConfirmation($order));
    });
});

require __DIR__.'/auth.php';
