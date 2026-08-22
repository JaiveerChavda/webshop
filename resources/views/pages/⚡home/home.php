<?php

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{

    public int $perPage = 20;

    public function loadMore()
    {
        $this->perPage += 10;
    }

    #[Computed()]
    public function Products()
    {
        return Product::with('variants')->paginate(perPage:$this->perPage);
    }
};
