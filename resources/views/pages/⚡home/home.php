<?php

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed()]
    public function Products()
    {
        return Product::with('variants', 'images')->get();
    }
};