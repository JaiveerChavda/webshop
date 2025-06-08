<?php

namespace App\Livewire;

use App\Actions\AddProductVariantToCart;
use App\Models\Product;
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
    }

    public function render()
    {
        return view('livewire.show-product');
    }
}
