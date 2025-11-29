<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class CheckoutStatus extends Component
{
    #[Url()]
    public ?string $session_id = null;

    #[Computed()]
    public function order()
    {
        return auth()->user()->orders()->where('stripe_checkout_session_id', $this->session_id)->first();
    }
    public function render()
    {
        return view('livewire.checkout-status');
    }
}
