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

    public function increment($itemId)
    {
        CartFactory::make()->items()->find($itemId)->increment('quantity');
    }

    public function getTotalProperty()
    {
        return CartFactory::make()->total;
    }

    public function decrement($itemId)
    {
        $item = CartFactory::make()->items()->find($itemId);
        if($item->quantity > 1){
            $item->decrement('quantity');
        }
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
