<?php

namespace App\Livewire;

use App\Actions\WebShop\AddProductVariantToCart;
use App\Factories\CartFactory;
use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ShowProduct extends Component
{
    public string $productId;

    public string $variant;

    protected $rules = [
        'variant' => ['required', 'exists:product_variants,id'],
    ];

    public function mount()
    {
        $this->variant = $this->product->variants->value('id');
    }

    public function getProductProperty()
    {
        return Product::query()->findOrFail($this->productId);
    }

    public function addToCart(AddProductVariantToCart $cart)
    {
        $this->validate();

        $cart->add($this->variant);

        $this->dispatch('productAddedToCart');
        $this->dispatch('notification.created', type: 'success', message: 'Product added to your cart');
    }

    #[Computed()]
    public function isVariantAlreadyAddedToCart()
    {
        return CartFactory::make()->items()->pluck('product_variant_id')->contains((int) $this->variant);
    }

    public function render()
    {        
        return view('livewire.show-product');
    }
}
