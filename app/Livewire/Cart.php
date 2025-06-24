<?php

namespace App\Livewire;

use App\Factories\CartFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public function getCartProperty()
    {
        return CartFactory::make()->loadMissing(['items','items.variant','items.product']);
    }

    #[On('productRemovedFromCart')]
    public function getItemsProperty()
    {
        return $this->cart->items;
    }

    public function increment($itemId)
    {
        $this->cart->items->find($itemId)->increment('quantity');
    }    

    public function decrement($itemId)
    {
        $item = $this->cart->items->find($itemId);
        if($item->quantity > 1){
            $item->decrement('quantity');
        }
    }

    public function delete($itemId)
    {
        $cart = $this->cart;
        $cartItem = $cart->items->where('id',$itemId)->first; 
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
