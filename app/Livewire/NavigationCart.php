<?php

namespace App\Livewire;

use App\Factories\CartFactory;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('added-product-to-cart')]
class NavigationCart extends Component
{
    public function getCountProperty()
    {
        return CartFactory::make()->items()->sum('quantity');
    }
    public function render()
    {
        return view('livewire.navigation-cart');
    }
}
