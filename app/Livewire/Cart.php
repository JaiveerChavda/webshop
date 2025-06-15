<?php

namespace App\Livewire;

use App\Factories\CartFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Cart extends Component
{
    public function getItemsProperty()
    {
        return CartFactory::make()->items;
    }

    public function delete($itemId)
    {
        $cart = CartFactory::make();
        $cartItem = $cart->items()->where('id',$itemId)->first(); 
        if(! $cartItem){
            throw new ModelNotFoundException();
        }

        $cartItem->delete();
        $this->dispatch('productRemovedFromCart');
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
