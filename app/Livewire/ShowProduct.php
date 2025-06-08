<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ShowProduct extends Component
{
    public string $productId;

    public function getProductProperty()
    {
        return Product::query()->findOrFail($this->productId);
    }

    public function render()
    {
        return view('livewire.show-product');
    }
}
